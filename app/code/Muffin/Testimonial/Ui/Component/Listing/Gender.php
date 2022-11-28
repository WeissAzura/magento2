<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Muffin\Testimonial\Ui\Component\Listing;

use Magento\Framework\Option\ArrayInterface;

/**
 * Source model for element with enable and disable variants.
 * @api
 * @since 100.0.2
 */
class Gender implements ArrayInterface
{

    const ENABLE_VALUE = 1;


    const DISABLE_VALUE = 0;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::ENABLE_VALUE, 'label' => __('Male')],
            ['value' => self::DISABLE_VALUE, 'label' => __('Female')],
        ];
    }
}
