<?php
namespace Muffin\Slider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Muffin\Slider\Model\BannerFactory;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'Muffin_Slider::banner';
    protected $resultPageFactory;
    protected $_bannerFactory;
    protected $_coreRegistry;
    /**
     * Edit constructor.
     *
     * @param PageFactory $resultPageFactory
     * @param BannerFactory $bannerFactory
     * @param Registry $registry
     * @param Context $context
     */
    public function __construct(
        PageFactory $resultPageFactory,
        BannerFactory $bannerFactory,
        Registry $registry,
        Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_bannerFactory = $bannerFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('banner_id');
        /** @var \Muffin\Slider\Model\Banner $banner */
        $banner = $this->_bannerFactory->create();

        if ($id) {
            $banner->load($id);
        }
        $this->_coreRegistry->register('muffinslider_banner', $banner);

        $values = $this->_getSession()->getData('muffinslider_banner', true);
        if ($values) {
            $banner->setData($values);
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Muffin_Slider::banner');
        $resultPage->getConfig()->getTitle()
            ->prepend($banner->getData('banner_id') ? $banner->getData('name') : 'New Banner');
        return $resultPage;
    }
}
