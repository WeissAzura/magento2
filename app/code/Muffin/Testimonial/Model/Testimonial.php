<?php

namespace Muffin\Testimonial\Model;

use Magento\Framework\Model\AbstractModel;
use Muffin\Testimonial\Model\ResourceModel\Testimonial as ResourceModel;

class Testimonial extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_testimonial_data_model';

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
