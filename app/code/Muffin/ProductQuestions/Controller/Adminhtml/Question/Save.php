<?php

namespace Muffin\ProductQuestions\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Muffin\ProductQuestions\Model\QuestionFactory;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Muffin_PQ::question';

    protected QuestionFactory $questionFactory;
    protected DateTime $date;

    public function __construct(
        Context $context,
        QuestionFactory $questionFactory,
        DateTime $date,
    ) {
        $this->date = $date;
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        try {
            $id = (int)$this->getRequest()->getParam('question_id');
            $date = $this->date->gmtDate();
            $objectManager = $this->questionFactory->create();
            $postdata = [
                    'question' => $data['question'],
                    'status' => $data['status'],
                    'answer' => $data['answer'],
                    'customer_name' => $data['customer_name'],
                    'customer_email' => $data['customer_email'],
                    'helpful' => $data['helpful'],
                    'updated_at' => $date
            ];
            $objectManager->setData($postdata)->setData('question_id', $id);
            $objectManager->save();
            $this->messageManager->addSuccessMessage(__('The Question has been saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Question has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['question_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
