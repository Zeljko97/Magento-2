<?php

namespace Acme\PoNumber\Model\ResourceModel\SalesOrder;

use Acme\PoNumber\Model\SalesOrder;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(SalesOrder::class, \Acme\PoNumber\Model\ResourceModel\SalesOrder::class);
    }
}
