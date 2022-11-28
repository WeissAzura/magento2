<?php

namespace Muffin\FAQ\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Muffin\FAQ\Model\QuestionFactory;

class SaveQuestion extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Muffin_FAQ::question';

    protected $questionFactory;
    protected $resultRedirectFactory;
    protected $date;

    public function __construct(Context $context, QuestionFactory $questionFactory, DateTime $date)
    {
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
            if ($id) {
                $postdata = [
                    'question' => $data['question'],
                    'status' => $data['status'],
                    'url_key' => $data['url_key'],
                    'answer' => $data['answer'],
                    'category_id' => $data['category_id'],
                    'updated_at' => $date
                ];
                $objectManager->setData($postdata)->setId($id);
            } else {
                $postdata = [
                    'question' => $data['question'],
                    'status' => $data['status'],
                    'url_key' => $data['url_key'],
                    'answer' => $data['answer'],
                    'category_id' => $data['category_id'],
                    'updated_at' => $date,
                    'created_at' => $date
                ];
                $objectManager->setData($postdata);
            }
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
