<?php
namespace Muffin\Slider\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Muffin\Slider\Model\ResourceModel\Slider\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
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
        /** @var $item \Muffin\Slider\Model\Slider */
        foreach ($items as $item) {
            $this->loadedData[$item->getData('slider_id')] = $item->getData();
        }

        return $this->loadedData;
    }
}
