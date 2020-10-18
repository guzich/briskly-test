<?php
namespace app;

use app\exception\XlsExchangeException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class XlsWriter
{
    private static $tmpDir = '/tmp';
    private static $tmpFilePrefix = 'items_';

    const ITEMS_FIRST_ROW_INDEX = 2;
    const ITEMS_HEADING_ROW_INDEX = 1;
    const ITEMS_FIRST_COL_INDEX = 1;

    public static function writeItems(array $items) {
        $spreadsheet = new Spreadsheet();

        try{

            $sheet = $spreadsheet->getActiveSheet();

            self::writeItemAttributesHeading($sheet);
            foreach($items as $itemIndex => $item) {
                self::writeItemRow($sheet, $itemIndex, $item);
            }

            $tmpFile = tempnam(self::$tmpDir, self::$tmpFilePrefix);
            if ($tmpFile === false) {
                throw new TmpFileCreateExchangeException(self::$tmpDir);
            }
            $writer = new Xlsx($spreadsheet);
            $writer->save($tmpFile);
            return $tmpFile;

        } catch(Exception $e) {
            throw new XlsExchangeException($e->getMessage(), $e->getCode(), $e);
        }

    }

    private static function writeItemRow(
        Worksheet $sheet,
        int $rowIndex,
        Item $item
    ) {
        foreach(Item::getValidAttributeKeys() as $attributeIndex => $attribute) {
            $sheet->setCellValueByColumnAndRow(
                self::ITEMS_FIRST_COL_INDEX + $attributeIndex,
                self::ITEMS_FIRST_ROW_INDEX + $rowIndex,
                $item->getAttribute($attribute)
            );
        }
    }

    private static function writeItemAttributesHeading(Worksheet $sheet) {
        foreach(Item::getValidAttributeKeys() as $attributeIndex => $attribute) {
            $sheet->setCellValueByColumnAndRow(
                self::ITEMS_FIRST_COL_INDEX + $attributeIndex,
                self::ITEMS_HEADING_ROW_INDEX,
                $attribute
            );
        }
    }
}
