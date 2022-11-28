<?php
namespace Muffin\MegaMenu\Controller\Adminhtml\Menu;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Muffin\MegaMenu\Model\MenuFactory;
use Muffin\MegaMenu\Model\ItemFactory;

class Delete extends Action
{
    protected MenuFactory $menuFactory;
    protected ItemFactory $itemFactory;
    protected $resultRedirectFactory;

    public function __construct(Context $context,ItemFactory $itemFactory, MenuFactory $menuFactory)
    {
        $this->itemFactory = $itemFactory;
        $this->menuFactory = $menuFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('menu_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->menuFactory->create();
                $model->load($id);
                $objectManager = ObjectManager::getInstance();
                $cat = $objectManager->get('Magento\Catalog\Model\Category')->load($model->getData('category_id'));
                $cat->delete();
                $items = $this->itemFactory->create()->getCollection()->addFieldToFilter('menu_id', $id);
                foreach ($items as $item) {
                    $item->delete();
                }
                $model->delete();
                $this->messageManager->addSuccess(__('The menu has been deleted.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['menu_id' => $id]);
            }
        }
    }
}
