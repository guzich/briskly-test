<?php
namespace app;

class BarcodeValidator
{
    const  BARCODE_VALID_LENGHT = 13;

    public static function validate($value): bool
    {
        $strLength = strlen($value);
        $isValid = is_string($value) && ($strLength == self::BARCODE_VALID_LENGHT);

        if ($isValid) {
            if (!preg_match('<\d{13}>', $value)) {
                $isValid = false;
            }
        }

        if ($isValid) {
            $isValid = self::checkControlDigit($value);
        }

        return $isValid;
    }

    /**
     *  Проверяет контрольную цифру EAN-13 в соответствии с алгоритмом:
     * 1. Суммировать цифры на четных позициях;
     * 2. Результат пункта 1 умножить на 3;
     * 3. Суммировать цифры на нечетных позициях;
     * 4. Суммировать результаты пунктов 2 и 3;
     * 5. Контрольное число — разница между окончательной суммой и
     * ближайшим к ней наибольшим числом, кратным 10-ти.
     */
    private static function checkControlDigit($value): bool
    {
        $oddSum = 0;
        $evenSum = 0;

        for($digitPosition = 0; $digitPosition < strlen($value) - 1; $digitPosition++) {
            if ($digitPosition%2) {
                $evenSum += (int) $value[$digitPosition];
            }else{
                $oddSum += (int) $value[$digitPosition];
            }
        }

        $finalSum = $oddSum + (3 * $evenSum);
        $rest = $finalSum % 10;
        if ($rest) {
            $controlDigit = 10 - $rest;
        }else{
            $controlDigit = 0;
        }

        $isValid = false;
        if ($controlDigit == ((int) substr($value,-1))) {
            $isValid = true;
        }

        return $isValid;
    }
}
