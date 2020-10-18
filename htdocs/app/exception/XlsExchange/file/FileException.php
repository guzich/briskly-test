<?php
namespace app\exception\XlsExchange\file;

use app\exception\XlsExchangeException;

class FileException extends XlsExchangeException{

    /**
     * @var string
     */
    protected $filePath;

    /**
     * описание ошибки
     * @var string
     */
    protected $errorDescription = 'File Error';

    public function __construct(string $filePath)
	{
		parent::__construct($this->errorDescription  . ': ' . $filePath);
		$this->filePath = $filePath;
	}

    /**
	 * @return string
	 */
	public function getFilePath(): string
	{
		return $this->filePath;
	}

}
