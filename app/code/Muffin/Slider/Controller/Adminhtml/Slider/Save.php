<?php
namespace Muffin\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Muffin\Slider\Model\SliderFactory;

class Save extends Action
{
    protected $sliderFactory;
    protected $resultRedirectFactory;
    protected $date;

    public function __construct(Context $context, SliderFactory $sliderFactory, DateTime $date)
    {
        $this->date = $date;
        $this->sliderFactory = $sliderFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        try {
            $id = (int)$this->getRequest()->getParam('slider_id');
            $date = $this->date->gmtDate();
            $objectManager = $this->sliderFactory->create();
            if ($id) {
                if ($data['design'] == 0) {
                    $postdata = [
                        'name' => $data['name'],
                        'status' => $data['status'],
                        'location' => $data['location'],
                        'design' => $data['design'],
                        'updated_at' => $date
                    ];
                } else {
                    $postdata = [
                        'name' => $data['name'],
                        'status' => $data['status'],
                        'location' => $data['location'],
                        'design' => $data['design'],
                        'loop' => $data['loop'],
                        'autoplay' => $data['autoplay'],
                        'autoplaySpeed' => $data['autoplaySpeed'],
                        'pauseOnHover' => $data['pauseOnHover'],
                        'updated_at' => $date
                    ];
                }
                $objectManager->setData($postdata)->setId($id);
                $objectManager->save();
                $this->messageManager->addSuccessMessage(__('The Slider has been saved.'));
            } else {
                if ($data['design'] == 0) {
                    $postdata = [
                        'name' => $data['name'],
                        'status' => $data['status'],
                        'location' => $data['location'],
                        'design' => $data['design'],
                        'created_at' => $date,
                        'updated_at' => $date
                    ];
                } else {
                    $postdata = [
                        'name' => $data['name'],
                        'status' => $data['status'],
                        'location' => $data['location'],
                        'design' => $data['design'],
                        'loop' => $data['loop'],
                        'autoplay' => $data['autoplay'],
                        'autoplaySpeed' => $data['autoplaySpeed'],
                        'pauseOnHover' => $data['pauseOnHover'],
                        'created_at' => $date,
                        'updated_at' => $date
                    ];
                }
                $objectManager->setData($postdata);
                $objectManager->save();
                $this->messageManager->addSuccessMessage(__('The Slider has been saved.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Slider has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['slider_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
