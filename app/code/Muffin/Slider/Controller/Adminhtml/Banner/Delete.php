<?php
namespace Muffin\Slider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Muffin\Slider\Model\BannerFactory;

class Delete extends Action
{
    protected $bannerFactory;
    protected $resultRedirectFactory;

    public function __construct(Context $context, BannerFactory $bannerFactory)
    {
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('banner_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->bannerFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The banner has been deleted.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['banner_id' => $id]);
            }
        }
    }
}
