<?php
namespace app\exception\XlsExchange\order;

use app\exception\XlsExchangeException;

class EmptyOrderException extends XlsExchangeException{

    public function __construct()
	{
		parent::__construct('Order doesn\'t contain any items');
	}

}
