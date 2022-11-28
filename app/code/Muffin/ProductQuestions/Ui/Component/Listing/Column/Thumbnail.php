<?php

namespace Muffin\ProductQuestions\Ui\Component\Listing\Column;

use Magento\Catalog\Api\ProductRepositoryInterfaceFactory;
use Magento\Catalog\Helper\Image;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnail extends Column
{
    protected Image $imageHelper;
    protected ProductRepositoryInterfaceFactory $productRepositoryFactory;

    public function __construct(
        ContextInterface $context,
        ProductRepositoryInterfaceFactory $productRepositoryFactory,
        UiComponentFactory $uiComponentFactory,
        Image $imageHelper,
        array $components = [],
        array $data = []
    ) {
        $this->productRepositoryFactory = $productRepositoryFactory;
        $this->imageHelper = $imageHelper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                $product = $this->productRepositoryFactory->create()->getById($item['product_id']);
                $url = $this->imageHelper->init($product, 'product_thumbnail_image')->getUrl();
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_orig_src'] = $url;
            }
        }
        return $dataSource;
    }
}
