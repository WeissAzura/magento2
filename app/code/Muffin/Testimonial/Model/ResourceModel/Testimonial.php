<?php

namespace Muffin\Testimonial\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Testimonial extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_testimonial_data_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('muffin_testimonial_data', 'id');
        $this->_useIsObjectNew = true;
    }
}
