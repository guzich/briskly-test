<?php
namespace app;

use FtpClient\FtpClient;
use FtpClient\FtpException;
use app\exception\XlsExchange\file\FtpSaveException;
use app\exception\XlsExchange\file\LocalFileSaveException;

class FileSaver
{
    private static $defaultFileName = 'items.xls';

    public static function saveToFtp(
        string $host,
        string $login,
        string $password,
        string $directory,
        string $sourceFile
    ) {
        try{
            $ftp = new FtpClient();
            $ftp->connect($host);
            $ftp->login($login, $password);
            $ftp->chdir($directory);
            $ftp->putFromPath($sourceFile);
            $ftp->rename(basename($sourceFile), self::$defaultFileName);
        } catch (FtpException $e){
            throw new FtpSaveException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public static function saveToFile(string $sourceFile, string $destFile) {
        if(!copy($sourceFile, $destFile)){
            throw new LocalFileSaveException($destFile);
        }
    }
}
