<?php
namespace Muffin\FAQ\Ui\Component\Listing;

use Magento\Framework\Data\OptionSourceInterface;
use Muffin\FAQ\Model\ResourceModel\Category\CollectionFactory;

class CategoryListing implements OptionSourceInterface
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
        $category= $this->collection->getItems();
        foreach ($category as $item) {
            if ($item->getData('status') == 1) {
                $options[] = ['value' => $item->getData('category_id'), 'label' => $item->getData('category')];
            }
        }
        return $options;
    }
}
