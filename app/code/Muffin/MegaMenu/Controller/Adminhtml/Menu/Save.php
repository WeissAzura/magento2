<?php

namespace Muffin\MegaMenu\Controller\Adminhtml\Menu;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Muffin\MegaMenu\Helper\Data;
use Muffin\MegaMenu\Model\ItemFactory;
use Muffin\MegaMenu\Model\MenuFactory;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Muffin_MegaMenu::design';
    protected ItemFactory $itemFactory;
    protected MenuFactory $menuFactory;
    protected DateTime $date;
    protected Data $helperData;
    public function __construct(
        Context $context,
        Data $helperData,
        ItemFactory $itemFactory,
        MenuFactory $menuFactory,
        DateTime $date,
    ) {
        $this->helperData = $helperData;
        $this->date = $date;
        $this->itemFactory = $itemFactory;
        $this->menuFactory = $menuFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        try {
            $id = (int)$this->getRequest()->getParam('menu_id');
            $date = $this->date->gmtDate();
            $menuManager = $this->menuFactory->create();
            $itemObject = $this->itemFactory->create();
            $objectManager = ObjectManager::getInstance();
            $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
            $store = $storeManager->getStore();
            $storeId = $store->getStoreId();
            $rootNodeId = $store->getRootCategoryId();
            $rootCat = $objectManager->get('Magento\Catalog\Model\Category')->load($rootNodeId);
            $categoryFactory=$objectManager->get('\Magento\Catalog\Model\CategoryFactory');
            $categoryTmp = $categoryFactory->create();
            if ($data['cat_name'] != '' and $data['cat_url'] != '') {
                $name = ucfirst($data['cat_name']);
                $url = strtolower($data['cat_url']);
                $categoryTmp->setName($name);
                $categoryTmp->setIsActive(true);
                $categoryTmp->setUrlKey($url);
                $categoryTmp->setParentId($rootCat->getId());
                $categoryTmp->setStoreId($storeId);
                $categoryTmp->setPath($rootCat->getPath());
                $categoryTmp->save();
            }
            if ($id) {
                $post_data = [
                    'status' => $data['status'],
                    'column_amount' => $data['column_amount'],
                    'menu_type' => $data['menu_type'],
                    'menu_name' => $data['menu_name'],
                    'menu_url' => $data['menu_url'],
                    'block_left' => $data['block_left'],
                    'block_right' => $data['block_right'],
                    'block_top' => $data['block_top'],
                    'category_id' => $data['category_id'] === 'New' ? $categoryTmp->getId() : $data['category_id'],
                    'block_bottom' => $data['block_bottom'],
                    'updated_at' => $date
                ];
                $menuManager->setData($post_data)->setId($id);
            } else {
                $post_data = [
                    'category_id' => $data['category_id'] === 'New' ? $categoryTmp->getId() : $data['category_id'],
                    'status' => $data['status'],
                    'column_amount' => $data['column_amount'],
                    'menu_type' => $data['menu_type'],
                    'menu_name' => $data['menu_name'],
                    'menu_url' => $data['menu_url'],
                    'block_left' => $data['block_left'],
                    'block_right' => $data['block_right'],
                    'block_top' => $data['block_top'],
                    'block_bottom' => $data['block_bottom'],
                    'updated_at' => $date,
                    'created_at' => $date
                ];
                $menuManager->setData($post_data);
            }
            $menuManager->save();
            $this->messageManager->addSuccessMessage(__('The Menu has been saved.'));
            if (array_key_exists('subcategory', $data)) {
                foreach ($data['subcategory'] as $category) {
                    if ($category['item_category_id']) {
                        $item_data = [
                            'item_name' => ucfirst($category['item_name']),
                            'item_url' => strtolower($category['item_url']),
                            'column_pos' => $category['column_pos'],
                            'pos_in_column' => $category['pos_in_column'],
                            'menu_id' => $menuManager->getId(),
                            'updated_at' => $date
                        ];
                        $subcategoryTmp = $categoryFactory->create()->load($category['item_category_id']);
                        $subcategoryTmp->setName(ucfirst($category['item_name']));
                        $subcategoryTmp->setUrlKey(strtolower($category['item_url']));
                        $subcategoryTmp->setDisplayMode($category['row_display']);
                        $subcategoryTmp->setData('page_layout', $category['row_layout']);
                        $subcategoryTmp->save();
                        $item_list = $itemObject->getCollection()->addFieldToFilter('category_id', $category['item_category_id']);
                        foreach ($item_list as $item) {
                            $item_ID = $item->getId();
                        }
                        $itemObject->setData($item_data)->setId($item_ID);
                    } else {
                        $subcategoryTmp = $categoryFactory->create();
                        $subcategoryTmp->setName(ucfirst($category['item_name']));
                        $subcategoryTmp->setIsActive(true);
                        $subcategoryTmp->setUrlKey(strtolower($category['item_url']));
                        $subcategoryTmp->setParentId($categoryTmp->getId());
                        $subcategoryTmp->setStoreId($storeId);
                        $subcategoryTmp->setDisplayMode($category['row_display']);
                        $subcategoryTmp->setData('page_layout', $category['row_layout']);
                        if ($data['category_id'] === 'New') {
                            $subcategoryTmp->setPath($categoryTmp->getPath());
                        } else {
                            $catPick = $objectManager->get('Magento\Catalog\Model\Category')->load($data['category_id']);
                            $subcategoryTmp->setPath($catPick->getPath());
                        }

                        $subcategoryTmp->save();
                        $item_data = [
                            'item_name' => ucfirst($category['item_name']),
                            'item_url' => strtolower($category['item_url']),
                            'column_pos' => $category['column_pos'],
                            'pos_in_column' => $category['pos_in_column'],
                            'menu_id' => $menuManager->getId(),
                            'category_id' => $subcategoryTmp->getId(),
                            'updated_at' => $date,
                            'created_at' => $date
                        ];
                        $itemObject->setData($item_data);
                    }
                    $itemObject->save();
                }
            }

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Menu has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['menu_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
