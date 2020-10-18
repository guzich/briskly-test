<?php
namespace app\exception\XlsExchange\file;

use app\exception\XlsExchange\file\FileException;

class EmptyInputFileException extends FileException{

    /**
     * описание ошибки
     * @var string
     */
    protected $errorDescription = 'Source file is empty';

}
