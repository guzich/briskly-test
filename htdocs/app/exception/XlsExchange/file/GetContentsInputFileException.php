<?php
namespace app\exception\XlsExchange\file;

use app\exception\XlsExchange\file\FileException;

class GetContentsInputFileException extends FileException{

    /**
     * описание ошибки
     * @var string
     */
    protected $errorDescription = 'Error while reading source file';

}
