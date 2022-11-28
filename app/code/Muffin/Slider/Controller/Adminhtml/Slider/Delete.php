<?php
namespace Muffin\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Muffin\Slider\Model\SliderFactory;

class Delete extends Action
{
    protected $sliderFactory;
    protected $resultRedirectFactory;

    public function __construct(Context $context, SliderFactory $sliderFactory)
    {
        $this->sliderFactory = $sliderFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('slider_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->sliderFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The slider has been deleted.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['slider_id' => $id]);
            }
        }
    }
}
