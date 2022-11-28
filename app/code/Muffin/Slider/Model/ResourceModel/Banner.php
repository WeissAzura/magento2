<?php

namespace Muffin\Slider\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb
{


    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('muffin_bannerslider_banner', 'banner_id');
    }


}

