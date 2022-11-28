<?php

namespace Muffin\FAQ\Block\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Muffin\FAQ\Model\CategoryFactory;

class DeleteCategory implements ButtonProviderInterface
{
    protected Context $context;
    protected CategoryFactory $CategoryFactory;
    protected UrlInterface $urlBuilder;
    public function __construct(
        Context $context,
        CategoryFactory $CategoryFactory,
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->CategoryFactory = $CategoryFactory;
        $this->context = $context;
    }

    public function getButtonData()
    {
        $id = $this->context->getRequest()->getParam('category_id');
        $object = $this->CategoryFactory->create()->load($id);
        $data = [];
        $category_id = $object->getData('category_id');
        if ($category_id) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->urlBuilder->getUrl('*/*/delete', ['category_id' => $category_id]) . '\')',
            ];
        }
        return $data;
    }
}
