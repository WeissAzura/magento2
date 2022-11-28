<?php

namespace Muffin\Slider\Model\ResourceModel\Banner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Muffin\Slider\Model\Banner', 'Muffin\Slider\Model\ResourceModel\Banner');
    }
}
