<?php

namespace ConvertioCLI;

class CLIOptions
{
    private $raw_argv;
    public $args;
    public $free_values;
    public $input_files = array();

    public function __construct($argv)
    {
        $this->raw_argv = $argv;
        $this->args = array();
        $C = count($argv);
        for ($I = 1; $I < $C; $I++) {
            $V = $argv[$I];
            if (preg_match("~-(\w+)~", $V, $P)) {
                if (isset($argv[$I+1])) {
                    if (preg_match("~-(\w+)~", $argv[$I+1])) {
                        $this->args[$P[1]] = true;
                    } else {
                        $this->args[$P[1]] = $argv[$I+1];
                        $I++;
                    }
                } else {
                    $this->args[$P[1]] = true;
                }
            } else {
                $this->free_values[] = $V;
            }
        }

        $this->fillInputFiles();
    }

    public function isShowHelp()
    {
        return (
            empty($this->args) ||
            isset($this->args['help']) ||
            isset($this->args['h']) ||
            in_array($this->raw_argv, array('-?'))
        );
    }

    public function isShowVersion()
    {
        return (
            isset($this->args['V']) ||
            isset($this->args['version'])
        );
    }

    private function fillInputFiles()
    {
        if (count($this->free_values) == 0) {
            return;
        }

        $this->input_files = array();
        foreach ($this->free_values as $FN) {
            if (substr($FN, 0, 1) !== '/') {
                $FN = getcwd()."/".$FN;
            }

            if (file_exists($FN) && is_readable($FN)) {
                $this->input_files[] = $FN;
            }
        }
    }

    public function getAPIKey()
    {
        if (isset($this->args['apikey'])) {
            return $this->args['apikey'];
        }

        return getenv('CONVERTIO_API_KEY');
    }

    public function getOutputDir()
    {
        if (isset($this->args['o'])) {
            return $this->args['o'];
        }

        if (isset($this->args['outputdir'])) {
            return $this->args['outputdir'];
        }

        return getcwd();
    }

    public function getOutputFormat()
    {
        if (isset($this->args['f'])) {
            return $this->args['f'];
        }

        if (isset($this->args['format'])) {
            return $this->args['format'];
        }
        return '';
    }
}
