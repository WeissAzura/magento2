<?php

namespace Muffin\FAQ\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Muffin\FAQ\Model\CategoryFactory;

class Edit extends Action implements HttpGetActionInterface
{

    const ADMIN_RESOURCE = 'Muffin_FAQ::category';
    protected $resultPageFactory;
    protected $categoryFactory;
    protected $_coreRegistry;
    /**
     * Edit constructor.
     *
     * @param PageFactory $resultPageFactory
     * @param CategoryFactory $categoryFactory
     * @param Registry $registry
     * @param Context $context
     */
    public function __construct(
        PageFactory $resultPageFactory,
        CategoryFactory $categoryFactory,
        Registry $registry,
        Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('category_id');
        $category = $this->categoryFactory->create();

        if ($id) {
            $category->load($id);
        }
        $this->_coreRegistry->register('muffin_category', $category);

        $values = $this->_getSession()->getData('muffin_category', true);
        if ($values) {
            $category->setData($values);
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Muffin_FAQ::category');
        $resultPage->getConfig()->getTitle()
            ->prepend($category->getData('category_id') ? $category->getData('category') : 'New Category');
        return $resultPage;
    }
}
