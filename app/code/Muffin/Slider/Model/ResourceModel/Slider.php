<?php

namespace Muffin\Slider\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Slider extends AbstractDb
{


    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('muffin_bannerslider_slider', 'slider_id');
    }


}

