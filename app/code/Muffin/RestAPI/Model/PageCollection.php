<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Muffin\RestAPI\Model;

use Magento\Cms\Model\ResourceModel\AbstractCollection;

/**
 * CMS page collection
 */
class PageCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'page_id';


    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'cms_page_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'page_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Magento\Cms\Model\Page::class, \Magento\Cms\Model\ResourceModel\Page::class);
        $this->_map['fields']['page_id'] = 'main_table.page_id';
        $this->_map['fields']['store'] = 'store_table.store_id';
    }


    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
            $this->setFlag('store_filter_added', true);
        }

        return $this;
    }
}
