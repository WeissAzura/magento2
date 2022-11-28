<?php

namespace Muffin\FAQ\Ui\Component\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Muffin\FAQ\Model\ResourceModel\Category\CollectionFactory;
/**
 * DataProvider component.
 */
class CategoryProvider extends AbstractDataProvider
{

    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $CollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $CollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->loadedData[$item->getData('category_id')] = $item->getData();
        }
        return $this->loadedData;
    }
}
