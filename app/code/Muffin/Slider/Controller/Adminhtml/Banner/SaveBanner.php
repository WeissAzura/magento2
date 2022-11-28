<?php
namespace Muffin\Slider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Muffin\Slider\Helper\Data;
use Muffin\Slider\Model\BannerFactory;

class SaveBanner extends Action
{
    protected BannerFactory $bannerFactory;
    protected $resultRedirectFactory;
    protected DateTime $date;
    protected ResourceConnection $resource;
    protected Data $helperData;

    public function __construct(
        Context $context,
        BannerFactory $bannerFactory,
        DateTime $date,
        ResourceConnection $resource,
        Data $helperData
    ) {
        $this->date = $date;
        $this->resource = $resource;
        $this->bannerFactory = $bannerFactory;
        $this->helperData = $helperData;
        parent::__construct($context);
    }
    public function saveSliders($data, $id)
    {
        $connection = $this->resource->getConnection();
        $tableName = $connection->getTableName('muffin_bannerslider_banner_slider');
        $query = 'SELECT slider_id FROM ' . $tableName . ' WHERE banner_id = ' . $id;
        $stored_table = $connection->fetchAll($query);
        if (isset($data['sliders_ids'])) {
            foreach ($data['sliders_ids'] as $item) {
                if (!in_array(['slider_id'=>$item], $stored_table)) {
                    $dataset = [
                        'slider_id' => $item,
                        'banner_id' => $id,
                        'position' => $this->helperData->getBannerCollection($item)->getSize(),
                    ];
                    try {
                        $connection->insert($tableName, $dataset);
                    } catch (\Exception $e) {
                        $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
                    }
                }
            }
            foreach ($stored_table as $slider) {
                if (!in_array($slider['slider_id'], $data['sliders_ids'])) {
                    $query = 'SELECT position FROM ' . $tableName . ' WHERE slider_id = ' . intval($slider) . ' AND banner_id = ' . intval($id);
                    $pos = $connection->fetchAll($query);
                    $query = 'DELETE FROM ' . $tableName . ' WHERE slider_id = ' . intval($slider['slider_id']) . ' AND banner_id = ' . intval($id);
                    $connection->query($query);
                    $query = 'UPDATE ' . $tableName . ' SET position = position - 1  WHERE position > ' . $pos[0]['position'] . ' AND slider_id = ' . intval($slider);
                    $connection->query($query);
                }
            }
        }
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        try {
            $id = (int)$this->getRequest()->getParam('banner_id');
            $date = $this->date->gmtDate();
            $objectManager = $this->bannerFactory->create();
            if ($id) {
                $postdata = [
                    'name' => $data['name'],
                    'status' => $data['status'],
                    'image' => $data['image'],
                    'updated_at' => $date
                ];
                $objectManager->addData($postdata)->setId($id);
                $objectManager->save();
                $this->saveSliders($data, $id);
                $this->messageManager->addSuccessMessage('The Banner has been saved.');
            } else {
                $postdata = [
                    'name' => $data['name'],
                    'status' => $data['status'],
                    'image' => $data['image'],
                    'created_at' => $date,
                    'updated_at' => $date
                ];
                $objectManager->addData($postdata);
                $objectManager->save();
                $this->saveSliders($data, $objectManager->getData('banner_id'));
                $this->messageManager->addSuccessMessage(__('The Banner has been saved.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Banner has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['banner_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
