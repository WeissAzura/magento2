<?php

namespace Muffin\Testimonial\Model\ResourceModel\Testimonial;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Muffin\Testimonial\Model\ResourceModel\Testimonial as ResourceModel;
use Muffin\Testimonial\Model\Testimonial as Model;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_testimonial_data_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
