<?php

namespace Muffin\Testimonial\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Muffin\Testimonial\Model\TestimonialFactory;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Muffin_Testimonial::manage';
    protected $testimonialFactory;
    protected $resultRedirectFactory;
    protected $date;
    public function __construct(Context $context, TestimonialFactory $testimonialFactory, DateTime $date)
    {
        $this->date = $date;
        $this->testimonialFactory = $testimonialFactory;
        parent::__construct($context);
    }
    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        try {
            $id = (int)$this->getRequest()->getParam('id');
            $date = $this->date->gmtDate();
            $objectManager = $this->testimonialFactory->create();
            if ($id) {
                $postdata = [
                    'name' => $data['name'],
                    'content' => $data['content'],
                    'gender' => $data['gender'],
                    'updated_at' => $date
                ];
                $objectManager->setData($postdata)->setId($id);
            } else {
                $postdata = [
                    'name' => $data['name'],
                    'content' => $data['content'],
                    'gender' => $data['gender'],
                    'updated_at' => $date,
                    'created_at' => $date
                ];
                $objectManager->setData($postdata);
            }
            $objectManager->save();
            $this->messageManager->addSuccessMessage(__('The Testimony has been saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Testimony has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
