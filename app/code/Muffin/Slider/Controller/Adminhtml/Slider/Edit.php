<?php
namespace Muffin\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Muffin\Slider\Model\SliderFactory;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'Muffin_Slider::slider';
    protected $resultPageFactory;
    protected $_sliderFactory;
    protected $_coreRegistry;

    /**
     * Edit constructor.
     *
     * @param PageFactory $resultPageFactory
     * @param SliderFactory $sliderFactory
     * @param Registry $registry
     * @param Context $context
     */
    public function __construct(
        PageFactory $resultPageFactory,
        SliderFactory $sliderFactory,
        Registry $registry,
        Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_sliderFactory = $sliderFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('slider_id');
        /** @var \Muffin\Slider\Model\Slider $slider */
        $slider = $this->_sliderFactory->create();

        if ($id) {
            $slider->load($id);
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Muffin_Slider::slider');
        $resultPage->getConfig()->getTitle()
            ->prepend($slider->getData('slider_id') ? $slider->getData('name') : 'New Slider');
        return $resultPage;
    }
}
