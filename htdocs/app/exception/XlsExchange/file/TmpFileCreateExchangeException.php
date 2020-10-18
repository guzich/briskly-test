<?php
namespace app\exception\XlsExchange\file;

use app\exception\XlsExchangeException;

class TmpFileCreateExchangeException extends XlsExchangeException{

    /**
     * @var string
     */
    protected $dir;

    /**
     * описание ошибки
     * @var string
     */
    protected $errorDescription = 'Can\'t create temporary file in directory: ';

    public function __construct(string $dir)
	{
		parent::__construct($this->errorDescription  . ': ' . $dir);
		$this->dir = $dir;
	}

    /**
	 * @return string
	 */
	public function getDir(): string
	{
		return $this->dir;
	}

}
