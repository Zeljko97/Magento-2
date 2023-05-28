<?php

namespace Learning\ClothingMaterial\Model\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Exception\LocalizedException;

class Material extends AbstractBackend
{
    /**
     * Validation on save product attribute.
     *
     * @param $object
     * @return void
     * @throws LocalizedException
     */
    public function validate($object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        if ($value == 'fur') {
            throw new LocalizedException(__('Bottom cannot be fur'));
        }
    }
}
