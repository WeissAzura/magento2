<?php
namespace Muffin\Testimonial\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Muffin\Testimonial\Model\TestimonialFactory;

class Delete extends Action
{
    protected $testimonialFactory;
    protected $resultRedirectFactory;

    public function __construct(Context $context, TestimonialFactory $testimonialFactory)
    {
        $this->testimonialFactory = $testimonialFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->testimonialFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The testimony has been deleted.'));
                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
    }
}
