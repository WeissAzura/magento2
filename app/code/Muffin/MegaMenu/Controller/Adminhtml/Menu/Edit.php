<?php

namespace Muffin\MegaMenu\Controller\Adminhtml\Menu;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\PageFactory;
use Muffin\MegaMenu\Model\MenuFactory;

class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Muffin_MegaMenu::design';
    protected $resultPageFactory;
    protected $menuFactory;

    public function __construct(
        PageFactory $resultPageFactory,
        MenuFactory $menuFactory,
        Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->menuFactory = $menuFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('menu_id');
        $menu = $this->menuFactory->create();
        if ($id) {
            $menu->load($id);
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Muffin_MegaMenu::design');
        $objectManager = ObjectManager::getInstance();
        if ($menu->getData('menu_name') === '' and $menu->getData('category_id')) {
            $name = $objectManager->get('Magento\Catalog\Model\Category')->load($menu->getData('category_id'))->getName();
        } else {
            $name = 'New Menu Link';
        }
        $resultPage->getConfig()->getTitle()
            ->prepend($name);
        return $resultPage;
    }
}
