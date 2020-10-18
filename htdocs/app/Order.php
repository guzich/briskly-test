<?php
namespace app;

use app\exception\XlsExchange\order\EmptyOrderException;
use app\exception\XlsExchange\order\MissItemsOrderException;

class Order
{
    private $items = [];
    //other order properties if needed

    public function loadDataFromArray(array $data) {
        if (isset($data['items'])) {
            $brokenItems = [];
            foreach($data['items'] as $item) {
                if (isset($item['item'])) {
                    $itemObj = new Item();
                    $itemObj->load($item['item']);
                    if ($itemObj->validate()) {
                        $this->addItem($itemObj);
                    }else{
                        $brokenItems []= $itemObj;
                    }
                }
            }
            if (!$this->items) {
                throw new EmptyOrderException();
            }elseif ($brokenItems) {
                throw new MissItemsOrderException($brokenItems);
            }
        }else{
            throw new EmptyOrderException();
        }
    }

    public function getItems() {
        return $this->items;
    }

    private function addItem(Item $item) {
        $this->items []= $item;
    }
}
