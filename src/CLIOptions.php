<?php

namespace ConvertioCLI;

class CLIOptions
{
    private $raw_argv;
    private $args;
    private $input_files = array();

    public function __construct($argv)
    {
        $this->raw_argv = $argv;
        $this->args = getopt('f:o:Vh', ['format:', 'outputdir:', 'version', 'help', 'apikey:']);

        $this->fillInputFiles(array_slice($argv, 1));
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

    private function fillInputFiles($argv)
    {
        $fileArguments = $this->getFileArguments($argv);

        if (count($fileArguments) === 0)
            return;

        foreach ($fileArguments as $fileArgument) {
            if ($fileArgument[0] !== DIRECTORY_SEPARATOR) {
                $fileArgument = getcwd() . DIRECTORY_SEPARATOR . $fileArgument;
            }

            if (!is_dir($fileArgument) && is_readable($fileArgument)) {
                $this->input_files[] = $fileArgument;
            }
        }
    }

    private function getFileArguments($argv)
    {
        return array_filter($argv, function ($argument) {
            $argument = trim($argument, '-');
            return !in_array($argument, array_keys($this->args)) && !in_array($argument, $this->args);
        });
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
            return rtrim($this->args['o'], DIRECTORY_SEPARATOR);
        }

        if (isset($this->args['outputdir'])) {
            return rtrim($this->args['outputdir'], DIRECTORY_SEPARATOR);
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

    public function getInputFiles()
    {
        return $this->input_files;
    }
}
