<?php

namespace Muffin\FAQ\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Muffin\FAQ\Model\CategoryFactory;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Muffin_FAQ::category';

    protected $CategoryFactory;
    protected $resultRedirectFactory;
    protected $date;
    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function __construct(Context $context, CategoryFactory $CategoryFactory, DateTime $date)
    {
        $this->date = $date;
        $this->CategoryFactory = $CategoryFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        try {
            $id = (int)$this->getRequest()->getParam('category_id');
            $date = $this->date->gmtDate();
            $objectManager = $this->CategoryFactory->create();
            if ($id) {
                $postdata = [
                    'category' => $data['category'],
                    'status' => $data['status'],
                    'url_key' => $data['url_key'],
                    'updated_at' => $date
                ];
                $objectManager->setData($postdata)->setId($id);
            } else {
                $postdata = [
                        'category' => $data['category'],
                        'status' => $data['status'],
                        'url_key' => $data['url_key'],
                        'updated_at' => $date,
                        'created_at' => $date
                    ];
                $objectManager->setData($postdata);
            }
            $objectManager->save();
            $this->messageManager->addSuccessMessage(__('The Category has been saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Category has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['category_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
