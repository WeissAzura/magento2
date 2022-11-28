<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Muffin\ProductQuestions\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Source model for element with enable and disable variants.
 * @api
 * @since 100.0.2
 */
class Submission implements ArrayInterface
{

    const ENABLE_VALUE = 1;


    const DISABLE_VALUE = 0;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::ENABLE_VALUE, 'label' => 'Automatically'],
            ['value' => self::DISABLE_VALUE, 'label' =>  'Manual'],
        ];
    }
    public function toArray()
    {
        return [self::DISABLE_VALUE => __('Manual'), self::ENABLE_VALUE => __('Automatically')];
    }
}
