<?php
namespace app;

use app\exception\XlsExchange\order\MissItemsOrderException;
use app\exception\XlsExchangeException;
use Exception;

class XlsExchange
{

    private $pathToInputJsonFile;
    private $pathToOutputXlsxFile;
    private $ftpHost;
    private $ftpLogin;
    private $ftpPassword;
    private $ftpDir;

    public function export() {
        $orderDataArray = JsonReader::readFile($this->pathToInputJsonFile);

        $order = new Order();
        try {
            $order->loadDataFromArray($orderDataArray);
        } catch(MissItemsOrderException $e) {
            // $e->getItems();
            // do nothing (write to xls valid items)
        }

        $xlsFile = XlsWriter::writeItems($order->getItems());

        try {
            if (
                $this->ftpHost
                && $this->ftpLogin
                && $this->ftpPassword
                && $this->ftpDir
            ) {
                FileSaver::saveToFtp(
                    $this->ftpHost,
                    $this->ftpLogin,
                    $this->ftpPassword,
                    $this->ftpDir,
                    $xlsFile
                );
            } elseif($this->pathToOutputXlsxFile) {
                FileSaver::saveToFile($xlsFile, $this->pathToOutputXlsxFile);
            } else{
                throw new XlsExchangeException(
                    'Either ftp credentials or local file path must be setted'
                );
            }
        } catch (Exception $e){
            if(file_exists($xlsFile)){
                unlink($xlsFile);
            }
            throw $e;
        }

        if(file_exists($xlsFile)){
            unlink($xlsFile);
        }
    }

    public function setInputFile(string $filePath): self
    {
        $this->pathToInputJsonFile = $filePath;
        return $this;
    }

    public function setOutputFile(string $filePath): self
    {
        $this->pathToOutputXlsxFile = $filePath;
        return $this;
    }

    public function setOutputFtp(
        string $ftpHost,
        string $ftpLogin,
        string $ftpPassword,
        string $ftpDir
    ): self {
        $this->ftpHost = $ftpHost;
        $this->ftpLogin = $ftpLogin;
        $this->ftpPassword = $ftpPassword;
        $this->ftpDir = $ftpDir;
        return $this;
    }
}
