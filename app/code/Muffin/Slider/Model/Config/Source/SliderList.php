<?php
namespace Muffin\Slider\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Muffin\Slider\Model\ResourceModel\Slider\CollectionFactory;

class SliderList implements OptionSourceInterface
{
    protected $collection;

    public function __construct(
        CollectionFactory $CollectionFactory,
    ) {
        $this->collection = $CollectionFactory->create();
    }

    public function toOptionArray()
    {
        $options = [['label' => '', 'value' => '']];
        $sliders= $this->collection->getItems();
        foreach ($sliders as $item) {
            if ($item->getData('status') == 1) {
                $options[] = ['value' => $item->getData('slider_id'), 'label' => $item->getData('name')];
            }
        }
        return $options;
    }
}
