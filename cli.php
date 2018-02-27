<?php

if (PHP_SAPI != 'cli') {
    die('This is command line utility only');
}

require_once "autoload.php";

use Convertio\Convertio;
use ConvertioCLI\CLIOptions;
use ConvertioCLI\FilesOutput;
use ConvertioCLI\Info;

$CLIOptions = new CLIOptions($argv);

if ($CLIOptions->isShowHelp()) {
    Info::printHelp();
}

if ($CLIOptions->isShowVersion()) {
    Info::printVersion();
}

$APIKey = $CLIOptions->getAPIKey();
$OutFormat = $CLIOptions->getOutputFormat();
$OutDir = $CLIOptions->getOutputDir();
$Files = $CLIOptions->getInputFiles();

if (empty($APIKey)) {
    Info::printError("No API Key provided");
}

if (empty($OutFormat)) {
    Info::printError("No output format option set");
}

if (empty($Files)) {
    Info::printError("No readable input files");
}

$FO = new FilesOutput($Files);
$FO->updateConsole();

$APIs = array();
foreach ($Files as $I => $FN) {
    $FO->updateFileStep($FN, 'start');

    try {
        $APIs[$FN] = new Convertio($APIKey);
        $APIs[$FN]->start($FN, $OutFormat);
        $FO->updateFileStep($FN, 'convert');
    } catch (\Exception $e) {
        $FO->fileError($FN, $e->getMessage());
        unset($Files[$I]);
        if (isset($APIs[$FN])) {
            unset($APIs[$FN]);
        }
    }
}

while (count($APIs) > 0) {
    foreach ($APIs as $FN => $API) {
        try {
            $API->status();
            $FO->updateFileStep($FN, $API->step, $API->step_percent);

            if ($API->step == 'finish') {
                $FO->updateFileStatus($FN, 'Done! [' . $API->result_size . ' Bytes]');

                $OutFN = $OutDir . "/" . basename($FN) . "." . strtolower($OutFormat);
                $API->download($OutFN);
                $API->delete();

                $FO->updateFileStatus($FN, 'Done! => ' . $OutFN . ' [' . $API->result_size . ' Bytes]');

                unset($APIs[$FN]);
            }
        } catch (\Exception $e) {
            if (!empty($API->result_public_url)) {
                $FO->fileError($FN, $e->getMessage() . " [Try download it manually: " . $API->result_public_url . "]");
            } else {
                $FO->fileError($FN, $e->getMessage());
            }

            unset($APIs[$FN]);
        }
    }
    usleep(100000);
}

Info::printLine("\nAll Done!\n");
