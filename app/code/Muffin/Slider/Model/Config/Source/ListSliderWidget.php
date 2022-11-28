<?php
namespace Muffin\Slider\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Muffin\Slider\Model\SliderFactory;

class ListSliderWidget implements OptionSourceInterface
{
    protected $sliderFactory;

    public function __construct(
        SliderFactory $sliderFactory,
    ) {
        $this->sliderFactory = $sliderFactory;
    }

    public function toOptionArray()
    {
        $options = [['label' => '', 'value' => '']];
        $sliders = $this->sliderFactory->create()->getCollection()->addFieldToFilter('location', 'custom.snippet-code');
        foreach ($sliders as $item) {
            if ($item->getData('status') == 1) {
                $options[] = ['value' => $item->getData('slider_id'), 'label' => $item->getData('name')];
            }
        }
        return $options;
    }
}
