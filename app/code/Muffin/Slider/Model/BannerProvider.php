<?php
namespace Muffin\Slider\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Muffin\Slider\Model\ResourceModel\Banner\CollectionFactory;

class BannerProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $_loadedData;
    protected ResourceConnection $resource;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $CollectionFactory,
        ResourceConnection $resource,
        array $meta = [],
        array $data = []
    ) {
        $this->resource = $resource;
        $this->collection = $CollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $connection = $this->resource->getConnection();
        $tableName = $connection->getTableName('muffin_bannerslider_banner_slider');
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $banners= $this->collection->getItems();
        foreach ($banners as $banner) {
            $id = $banner->getData('banner_id');
            $this->_loadedData[$banner->getData('banner_id')] = $banner->getData();
            $query = "SELECT slider_id FROM `" . $tableName . "` WHERE banner_id = $id";
            $result = $connection->fetchAll($query);
            $arr = [];
            foreach ($result as $i) {
                $arr[] = $i['slider_id'];
            }
            $this->_loadedData[$banner->getData('banner_id')]['sliders_ids'] = $arr;
        }
        return $this->_loadedData;
    }
}
