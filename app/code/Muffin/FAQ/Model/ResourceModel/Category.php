<?php

namespace Muffin\FAQ\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Category extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_faq_category_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('muffin_faq_category', 'category_id');
        $this->_useIsObjectNew = true;
    }
}
