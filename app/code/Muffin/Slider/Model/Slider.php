<?php

namespace Muffin\Slider\Model;

use \Magento\Framework\Model\AbstractModel;

class Slider extends AbstractModel
{
    const CACHE_TAG = 'muffin_bannerslider_slider';
    protected $_eventPrefix = 'muffin_bannerslider_slider';

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    /**
     * Initialize resource model
     * @return void
     */
    public function _construct()
    {
        $this->_init('Muffin\Slider\Model\ResourceModel\Slider');
    }


}

