<?php

namespace Muffin\MegaMenu\Model;

use Magento\Framework\Model\AbstractModel;
use Muffin\MegaMenu\Model\ResourceModel\Item as ResourceModel;

class Item extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_megamenu_item_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
