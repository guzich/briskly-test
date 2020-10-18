<?php
namespace app\exception\XlsExchange\file;

use app\exception\XlsExchange\file\FileException;

class LocalFileSaveException extends FileException{

    /**
     * описание ошибки
     * @var string
     */
    protected $errorDescription = 'Can\'t save to local file';

}
