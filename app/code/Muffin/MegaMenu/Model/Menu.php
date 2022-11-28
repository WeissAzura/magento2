<?php

namespace Muffin\MegaMenu\Model;

use Magento\Framework\Model\AbstractModel;
use Muffin\MegaMenu\Model\ResourceModel\Menu as ResourceModel;

class Menu extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_megamenu_menu_model';

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
