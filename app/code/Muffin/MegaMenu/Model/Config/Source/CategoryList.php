<?php
namespace Muffin\MegaMenu\Model\Config\Source;

use Magento\Catalog\Helper\Category;
use Magento\Framework\Data\OptionSourceInterface;

class CategoryList implements OptionSourceInterface
{
    public Category $helperData;

    public function __construct(
        Category $helperData,
    ) {
        $this->helperData = $helperData;
    }

    public function toOptionArray()
    {
        $options = [['label' => '', 'value' => '']];
        $categories= $this->helperData->getStoreCategories();
        foreach ($categories as $item) {
            $options[] = ['value' => $item->getData('entity_id'), 'label' => $item->getData('name')];
        }
        $options[] = ['label' => 'Create New Category', 'value' => 'New'];
        return $options;
    }
}
