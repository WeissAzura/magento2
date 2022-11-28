<?php

namespace Muffin\MegaMenu\Model\ResourceModel\Menu;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Muffin\MegaMenu\Model\Menu as Model;
use Muffin\MegaMenu\Model\ResourceModel\Menu as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_megamenu_menu_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
