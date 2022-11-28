<?php
namespace Muffin\Slider\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class DesignOptions implements ArrayInterface
{
    const ENABLE_VALUE = 1;

    /**
     * Value which equal Disable for Enabledisable dropdown.
     */
    const DISABLE_VALUE = 0;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::DISABLE_VALUE, 'label' => __('Use system config')],
            ['value' => self::ENABLE_VALUE, 'label' => __('Manually config')],
        ];
    }
}
