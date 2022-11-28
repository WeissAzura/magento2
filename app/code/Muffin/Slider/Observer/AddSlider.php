<?php

namespace Muffin\Slider\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Muffin\Slider\Helper\Data;
use Muffin\Slider\Model\Config\Source\Location;

class AddSlider implements ObserverInterface
{
    protected Data $helperData;
    public function __construct(
        Data $helperData
    ) {
        $this->helperData = $helperData;
    }
    public function execute(Observer $observer)
    {
        $fullAction = $observer->getFullActionName();
        foreach ($this->helperData->getActiveSliders() as $slider) {
            $locations = array_filter(explode(',', $slider->getLocation()));
            foreach ($locations as $value) {
                if ($value === Location::USING_SNIPPET_CODE) {
                    continue;
                }
                [$pageType, $location] = explode('.', $value);
                if ($location != 'footer-container') {
                    $location = str_replace("-", ".", $location);
                }
                if ($pageType === 'allpage' || $fullAction === $pageType) {
                    $layout = '<referenceContainer name="' . $location . '">';
                    $layout .= '<block class="Muffin\Slider\Block\Slider" name="Slider_Block' . $slider->getData("slider_id") . '" template="Muffin_Slider::Slider.phtml"><arguments><argument name="Slider_ID" xsi:type="string">' . $slider->getData("slider_id") . '</argument></arguments>';
                    $layout .= '</block></referenceContainer>';
                    $observer->getLayout()->getUpdate()->addUpdate($layout);
                    $layout = '';
                }
            }
        }
    }
}
