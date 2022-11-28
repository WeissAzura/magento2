<?php

namespace Muffin\MegaMenu\Block\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Muffin\MegaMenu\Model\ItemFactory;

class DeleteItem implements ButtonProviderInterface
{
    protected Context $context;
    protected ItemFactory $itemFactory;
    protected UrlInterface $urlBuilder;
    public function __construct(
        Context $context,
        ItemFactory $itemFactory,
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->itemFactory = $itemFactory;
        $this->context = $context;
    }

    public function getButtonData()
    {
        $id = $this->context->getRequest()->getParam('item_id');
        $object = $this->itemFactory->create()->load($id);
        $data = [];
        $item_id = $object->getData('item_id');
        if ($item_id) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->urlBuilder->getUrl('*/*/delete', ['item_id' => $item_id]) . '\')',
            ];
        }
        return $data;
    }
}
