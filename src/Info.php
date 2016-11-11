<?php

namespace ConvertioCLI;

class Info
{
    static private $version = 0.2;

    private function printSystemMessage($msg)
    {
        return "\n" . $msg . "\n";
    }

    public static function printVersion()
    {
        echo self::printSystemMessage("Convertio (cli) v.". self::$version);
        die();
    }

    public static function printError($St)
    {
        echo self::printSystemMessage("Error: " . "\n" . $St);
        die();
    }

    public static function printLine($St)
    {
        echo self::printSystemMessage($St);
        die();
    }

    public static function printHelp()
    {
        echo self::printSystemMessage(
            <<<HELP
Convertio CLI Utility [Info: https://convertio.co/api/]

Usage: convertio [options] [files...]

Options:

  -h, --help                    output usage information
  -f, --format <format>         set the output format the file(s) should be converted to
  -o, --outputdir <directory>   set the directory for storing the output files. defaults to the working directory
  --apikey <value>              set the API key. Alternatively you can use the CONVERTIO_API_KEY environment variable
  -V, --version                 output the version number

Examples:
  $ export CONVERTIO_API_KEY=_YOUR_API_KEY_
  $ convertio -f pdf *.txt
HELP
        );

        die();
    }
}
