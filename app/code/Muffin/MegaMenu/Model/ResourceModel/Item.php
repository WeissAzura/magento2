<?php

namespace Muffin\MegaMenu\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Item extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_megamenu_item_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('muffin_megamenu_item', 'item_id');
        $this->_useIsObjectNew = true;
    }
}
