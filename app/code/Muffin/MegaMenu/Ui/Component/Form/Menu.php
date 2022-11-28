<?php

namespace Muffin\MegaMenu\Ui\Component\Form;

use Magento\Framework\App\ObjectManager;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Muffin\MegaMenu\Model\ItemFactory;
use Muffin\MegaMenu\Model\ResourceModel\Menu\CollectionFactory;

/**
 * DataProvider component.
 */
class Menu extends AbstractDataProvider
{

    protected $loadedData;
    protected ItemFactory $itemFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $CollectionFactory,
        ItemFactory $itemFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->itemFactory = $itemFactory;
        $this->collection = $CollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $arr = [];
            $this->loadedData[$item->getData('menu_id')] = $item->getData();
            $subCats = $this->itemFactory->create()->getCollection()->addFieldToFilter('menu_id', $item->getData('menu_id'));
            foreach ($subCats as $subCat) {
                $objectManager = ObjectManager::getInstance();
                $tempCat = $objectManager->get('Magento\Catalog\Model\Category')->load($subCat->getData('category_id'));
                $arr[] = [
                    'item_name' => $subCat->getData('item_name'),
                    'item_url' => $subCat->getData('item_url'),
                    'column_pos' => $subCat->getData('column_pos'),
                    'pos_in_column' => $subCat->getData('pos_in_column'),
                    'row_display' => $tempCat->getDisplayMode(),
                    'row_layout' => $tempCat->getData('page_layout'),
                    'item_category_id' => $subCat->getData('category_id'),
                ];
            }
            $this->loadedData[$item->getData('menu_id')]['subcategory'] = $arr;
        }
        return $this->loadedData;
    }
}
