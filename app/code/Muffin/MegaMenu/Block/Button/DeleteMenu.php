<?php

namespace Muffin\MegaMenu\Block\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Muffin\MegaMenu\Model\MenuFactory;

class DeleteMenu implements ButtonProviderInterface
{
    protected Context $context;
    protected MenuFactory $menuFactory;
    protected UrlInterface $urlBuilder;
    public function __construct(
        Context $context,
        MenuFactory $menuFactory,
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->menuFactory = $menuFactory;
        $this->context = $context;
    }

    public function getButtonData()
    {
        $id = $this->context->getRequest()->getParam('menu_id');
        $object = $this->menuFactory->create()->load($id);
        $data = [];
        $menu_id = $object->getData('menu_id');
        if ($menu_id) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->urlBuilder->getUrl('*/*/delete', ['menu_id' => $menu_id]) . '\')',
            ];
        }
        return $data;
    }
}
