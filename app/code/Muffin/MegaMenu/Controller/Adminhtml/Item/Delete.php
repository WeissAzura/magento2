<?php
namespace Muffin\MegaMenu\Controller\Adminhtml\Item;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Muffin\MegaMenu\Model\ItemFactory;

class Delete extends Action
{
    protected ItemFactory $itemFactory;
    protected $resultRedirectFactory;

    public function __construct(Context $context, ItemFactory $itemFactory)
    {
        $this->itemFactory = $itemFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('item_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->itemFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The item has been deleted.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['item_id' => $id]);
            }
        }
    }
}
