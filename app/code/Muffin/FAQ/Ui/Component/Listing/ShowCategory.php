<?php
namespace Muffin\FAQ\Ui\Component\Listing;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Muffin\FAQ\Model\CategoryFactory;

class ShowCategory extends Column
{
    protected CategoryFactory $CategoryFactory;
    public function __construct(
        CategoryFactory $CategoryFactory,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->CategoryFactory = $CategoryFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['category_id'])) {
                    $id = $item['category_id'];
                    $category = $this->CategoryFactory->create()->load($id);
                    $item[$this->getData('name')] = $category->getData('category');
                }
            }
        }
        return $dataSource;
    }
}
