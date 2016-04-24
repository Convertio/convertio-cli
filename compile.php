<?php

$FN = "release/convertio";
$PharFN = $FN.".phar";

if (file_exists($FN)) {
    unlink($FN);
}

if (file_exists($PharFN)) {
    unlink($PharFN);
}

if (!file_exists(dirname($PharFN))) {
    mkdir(dirname($PharFN), 0755, true);
}

$phar = new Phar(
    $PharFN,
    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
    basename($PharFN)
);

$phar->startBuffering();
$defaultStub = $phar->createDefaultStub('cli.php');
$phar->buildFromDirectory(".", '~\.php$~');
$phar->setStub("#!/usr/bin/env php \n".$defaultStub);
$phar->compressFiles(Phar::GZ);
$phar->stopBuffering();

unset($phar);
$phar = null;

rename($PharFN, $FN);
chmod($FN, 0755);
