<?php
namespace Muffin\Slider\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Muffin\Slider\Helper\Data;

class Banners extends Column
{
    /**
     * @var Data
     */
    protected $helperData;
    /**
     * Banners constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Data $helperData
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Data $helperData,
        array $components = [],
        array $data = []
    ) {
        $this->helperData = $helperData;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['slider_id'])) {
                    $id = $item['slider_id'];
                    $count = $this->helperData->getBannerCollection($id)->getSize();
                    if ($count > 0) {
                        $item[$this->getData('name')] = $count . '<span> banners </span>';
                    } else {
                        $item[$this->getData('name')] = '<b>' . "No banner added" . '</b>';
                    }
                }
            }
        }
        return $dataSource;
    }
}
