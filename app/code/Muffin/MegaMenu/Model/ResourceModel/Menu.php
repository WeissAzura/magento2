<?php

namespace Muffin\MegaMenu\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Menu extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_megamenu_menu_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('muffin_megamenu_menu', 'menu_id');
        $this->_useIsObjectNew = true;
    }
}
