<?php
namespace Muffin\FAQ\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Muffin\FAQ\Model\QuestionFactory;

class Delete extends Action
{
    protected $questionFactory;
    protected $resultRedirectFactory;

    public function __construct(Context $context, QuestionFactory $questionFactory)
    {
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('question_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->questionFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The question has been deleted.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['question_id' => $id]);
            }
        }
    }
}
