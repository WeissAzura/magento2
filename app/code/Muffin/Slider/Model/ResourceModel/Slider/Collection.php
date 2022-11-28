<?php

namespace Muffin\Slider\Model\ResourceModel\Slider;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Muffin\Slider\Model\Slider', 'Muffin\Slider\Model\ResourceModel\Slider');
    }
}
