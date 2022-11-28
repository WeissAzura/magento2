<?php

namespace Muffin\ProductQuestions\Ui\Component\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Muffin\ProductQuestions\Model\ResourceModel\Question\CollectionFactory;

class QuestionProvider extends AbstractDataProvider
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
            $this->loadedData[$item->getData('question_id')] = $item->getData();
        }
        return $this->loadedData;
    }
}
