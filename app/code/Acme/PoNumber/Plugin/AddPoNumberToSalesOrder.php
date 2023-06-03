<?php
declare(strict_types=1);

namespace Acme\PoNumber\Plugin;

use Acme\PoNumber\Model\ResourceModel\SalesOrder\Collection;
use Acme\PoNumber\Model\ResourceModel\SalesOrder\CollectionFactory;
use Magento\Sales\Api\OrderRepositoryInterface;

class AddPoNumberToSalesOrder
{
    private CollectionFactory $acmeSalesOrderCollectionFactory;

    /**
     * AddPoNumberToSalesOrder constructor.
     * @param CollectionFactory $acmeSalesOrderCollectionFactory
     */
    public function __construct(CollectionFactory $acmeSalesOrderCollectionFactory)
    {
        $this->acmeSalesOrderCollectionFactory = $acmeSalesOrderCollectionFactory;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param $result
     * @return mixed
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        $result
    ) {
        // First grab the record from custom database table by the order id.
        /** @var Collection $acmeSalesOrder */
        $acmeSalesOrderCollection = $this->acmeSalesOrderCollectionFactory->create();
        $acmeSalesOrder = $acmeSalesOrderCollection
            ->addFieldToFilter('order_id', $result->getId())
            ->getFirstItem();

        // Get the extension attributes that are currently assigned to this order
        $extensionAttributes = $result->getExtensionAttributes();

        // Call 'setData' on the property we want to set, with the value from custom table.
        $extensionAttributes->setData('po_number', $acmeSalesOrder->getData('po_number'));

        // After that, re-set the extension attributes containing the newly added data...
        $result->setExtensionAttributes($extensionAttributes);

        // return the result.
        return $result;
    }

    public function afterGetList(
        OrderRepositoryInterface $subject,
        $result
    ) {
        // Same thing here, and can save some time by passing the logic to afterGet.
        foreach ($result->getItems() as $order) {
            $this->afterGet($subject, $order);
        }

        return $result;
    }
}
