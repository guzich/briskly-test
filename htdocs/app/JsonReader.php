<?php
namespace app;

use app\exception\XlsExchange\file\NotFoundInputFileException;
use app\exception\XlsExchange\file\EmptyInputFileException;
use app\exception\XlsExchange\file\GetContentsInputFileException;
use app\exception\XlsExchange\file\JsonInputFileException;

class JsonReader{

    public static function readFile(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw (new NotFoundInputFileException($filePath));
        }

        $sourceFileContent = file_get_contents($filePath);

        if ($sourceFileContent === false) {
            throw (new GetContentsInputFileException($filePath));
        }elseif (empty($sourceFileContent)) {
            throw (new EmptyInputFileException($filePath));
        }

        $data = json_decode($sourceFileContent, true);

        if (!(is_array($data) && $data)) {
            $jsonError = json_last_error();
            if ($jsonError == JSON_ERROR_NONE) {
                $data = [];
            }else{
                throw (new JsonInputFileException($filePath, $jsonError));
            }
        }

        return $data;
    }

}
