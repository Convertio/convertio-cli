<?php

namespace ConvertioCLI;

class FilesOutput extends CLIOutput
{
    private $FilesOutput = array();

    public function __construct($Files)
    {
        parent::__construct();

        foreach ($Files as $FN) {
            $this->FilesOutput[$FN] = "Waiting... ";
        }
    }

    public function updateFileStatus($FN, $StatusSt)
    {
        $this->FilesOutput[$FN] = $StatusSt;
        $this->updateConsole();
    }

    public function updateConsole()
    {
        parent::printLines($this->getLinesToPrint());
    }

    private function getLinesToPrint()
    {
        $OutLines = array();
        foreach ($this->FilesOutput as $FN => $St) {
            $OutLines[] = $FN.": ".$St;
        }

        return $OutLines;
    }

    public function fileError($FN, $Message)
    {
        $this->updateFileStatus($FN, "Error: ".$Message);
    }

    public function updateFileStep($FN, $Step, $StepPercent = 0)
    {
        if ($Step == 'start') {
            $this->updateFileStatus($FN, 'Starting... ');
        } elseif ($Step == 'wait') {
            $this->updateFileStatus($FN, 'Waiting in queue... ');
        } elseif ($Step == 'upload') {
            $this->updateFileStatus($FN, 'Uploading ['.$StepPercent.'%]... ');
        } elseif ($Step == 'convert') {
            $this->updateFileStatus($FN, 'Converting... ');
        } elseif ($Step == 'finish') {
            $this->updateFileStatus($FN, 'Done! ');
        }
    }
}
