<?php
namespace app\exception\XlsExchange\file;

use app\exception\XlsExchange\file\FileException;

class NotFoundInputFileException extends FileException{

    /**
     * описание ошибки
     * @var string
     */
    protected $errorDescription = 'Error while decode JSON data from file';
    private $jsonErrorCode;

    public function __construct(string $filePath, int $errorCode)
	{
		parent::__construct($this->errorDescription  . ' [json_last_error code ' . $errorCode . ']: ' . $filePath);
		$this->filePath = $filePath;
        $this->jsonErrorCode = $errorCode;
	}

    /**
	 * @return int
	 */
	public function getJsonErrorCode(): int
	{
		return $this->jsonErrorCode;
	}

}
