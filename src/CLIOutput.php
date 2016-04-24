<?php

namespace ConvertioCLI;

class CLIOutput
{
    private $stdout;
    private $current_line_count = null;

    public function __construct()
    {
        $this->stdout = fopen('php://stdout', 'w');
    }

    public function __destruct()
    {
        fclose($this->stdout);
    }

    public function printString($St)
    {
        fputs($this->stdout, $St);
    }

    public function printLines($Lines)
    {
        if (isset($this->current_line_count)) {
            $this->clearMultipleLines($this->current_line_count);
        }
        $this->printString(join("\n", $Lines));
        $this->current_line_count = count($Lines);
    }

    private function clearMultipleLines($N)
    {
        if ($N <= 0) {
            return;
        }
      
        $this->clearLine();
        for ($I = 1; $I < $N; $I++) {
            $this->lineUp();
            $this->clearLine();
        }
    }

    private function lineStart()
    {
        $this->printString(chr(27)."[0G"); // 0 Column
    }

    private function lineUp()
    {
        $this->printString("\r\033[1A"); // chr(27)."[1A"
    }

    private function clearLine()
    {
        $this->printString("\r\033[K");
    }
}
