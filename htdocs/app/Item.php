<?php
namespace app;

class Item
{
    private $attributes;
    private static $validAttributeKeys = [
        'id',
        'barcode',
        'external_code',
        'external_id',
        'name',
        'type',
        'unit_id',
        'vat_rate'
    ];

    public function load(array $data)
    {
        foreach($data as $attributeKey => $attributeValue) {
            if (in_array($attributeKey, self::$validAttributeKeys)) {
                $this->attributes[$attributeKey] = $attributeValue;
            }
        }
    }

    public function validate(): bool
    {
        $isValid = isset($this->attributes['barcode']) ? BarcodeValidator::validate($this->attributes['barcode']) : false;
        if (!$isValid) {
            $this->errors['barcode'] = $this->attributes['barcode'] . ': некорректное значение для штрихкода';
        }

        return $isValid;
    }

    public function getAttribute(string $attributeName) {
        return $this->attributes[$attributeName] ?? null;
    }

    public static function getValidAttributeKeys(){
        return self::$validAttributeKeys;
    }
}
