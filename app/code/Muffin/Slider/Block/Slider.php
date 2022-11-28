<?php

namespace Muffin\Slider\Block;

use Magento\Framework\View\Element\Template;
use Muffin\Slider\Helper\Data;

class Slider extends Template
{
    public Data $helperData;

    public function __construct(
        Data $helperData,
        Template\Context $context,
        array $data = []
    ) {
        $this->helperData = $helperData;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('Muffin_Slider::Slider.phtml');
    }

    public function getSliderId()
    {
        if ($this->getData('Slider_ID')) {
            return $this->getData('Slider_ID');
        }

        return uniqid('-', false);
    }

    public function getBannerCollection()
    {
        return $this->helperData->getBannerCollection($this->getSliderId())->addFieldToFilter('status', 1);
    }
    public function getSliderOptions()
    {
        return $this->helperData->getBannerOptions($this->getSliderId());
    }
}
