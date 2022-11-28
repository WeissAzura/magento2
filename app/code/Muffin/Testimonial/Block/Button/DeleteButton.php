<?php

namespace Muffin\Testimonial\Block\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Muffin\Testimonial\Model\TestimonialFactory;

class DeleteButton implements ButtonProviderInterface
{
    protected Context $context;
    protected TestimonialFactory $testimonialFactory;
    protected UrlInterface $urlBuilder;
    public function __construct(
        Context $context,
        TestimonialFactory $testimonialFactory,
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->testimonialFactory = $testimonialFactory;
        $this->context = $context;
    }

    public function getButtonData()
    {
        $id = $this->context->getRequest()->getParam('id');
        $model = $this->testimonialFactory->create()->load($id);
        $data = [];
        if ($model->getData('id')) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->urlBuilder->getUrl('*/*/delete', ['id' => $model->getData('id')]) . '\')',
            ];
        }
        return $data;
    }
}
