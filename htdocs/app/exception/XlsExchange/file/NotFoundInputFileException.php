<?php
namespace app\exception\XlsExchange\file;

use app\exception\XlsExchange\file\FileException;

class NotFoundInputFileException extends FileException{

    /**
     * описание ошибки
     * @var string
     */
    protected $errorDescription = 'Source file with json data is not found';

}
