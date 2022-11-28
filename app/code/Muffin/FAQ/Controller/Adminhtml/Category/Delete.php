<?php
namespace Muffin\FAQ\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Muffin\FAQ\Model\CategoryFactory;

class Delete extends Action
{
    protected $categoryFactory;
    protected $resultRedirectFactory;

    public function __construct(Context $context, CategoryFactory $categoryFactory)
    {
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('category_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->categoryFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The category has been deleted.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['category_id' => $id]);
            }
        }
    }
}
