<?php

namespace Muffin\FAQ\Model;

use Magento\Framework\Model\AbstractModel;
use Muffin\FAQ\Model\ResourceModel\Category as ResourceModel;

class Category extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_faq_category_model';

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
