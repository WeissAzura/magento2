<?php

namespace Muffin\FAQ\Block\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Muffin\FAQ\Model\QuestionFactory;

class DeleteQuestion implements ButtonProviderInterface
{
    protected Context $context;
    protected QuestionFactory $questionFactory;
    protected UrlInterface $urlBuilder;
    public function __construct(
        Context $context,
        QuestionFactory $questionFactory,
        UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->questionFactory = $questionFactory;
        $this->context = $context;
    }

    public function getButtonData()
    {
        $id = $this->context->getRequest()->getParam('question_id');
        $model = $this->questionFactory->create()->load($id);
        $data = [];
        if ($model->getData('question_id')) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->urlBuilder->getUrl('*/*/delete', ['question_id' => $model->getData('question_id')]) . '\')',
            ];
        }
        return $data;
    }
}
