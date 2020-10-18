<?php
namespace app\exception\XlsExchange\order;

use app\exception\XlsExchangeException;

class MissItemsOrderException extends XlsExchangeException{

    private $items;

    public function __construct(array $items)
	{
        parent::__construct('There are some items not added to order');
        $this->items = $items;
	}

    public function getItems() {
        return $this->items;
    }

}
