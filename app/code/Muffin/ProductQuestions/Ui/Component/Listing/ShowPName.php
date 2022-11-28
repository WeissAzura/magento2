<?php
namespace Muffin\ProductQuestions\Ui\Component\Listing;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Catalog\Api\ProductRepositoryInterfaceFactory;

class ShowPName extends Column
{
    protected ProductRepositoryInterfaceFactory $productRepositoryFactory;
    public function __construct(
        ProductRepositoryInterfaceFactory $productRepositoryFactory,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->productRepositoryFactory = $productRepositoryFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['product_id'])) {
                    $product = $this->productRepositoryFactory->create()->getById($item['product_id']);
                    $item[$this->getData('name')] = $product->getData('name');
                }
            }
        }
        return $dataSource;
    }
}
