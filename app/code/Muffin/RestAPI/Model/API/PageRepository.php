<?php
namespace Muffin\RestAPI\Model\API;

use Magento\Framework\Exception\LocalizedException;
use Muffin\RestAPI\API\PageRepositoryITF;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;

/**
 * Class ProductRepository
 */
class PageRepository implements PageRepositoryITF
{
    protected CollectionFactory $pageFactory;
    public function __construct(
        CollectionFactory $pageFactory,
    ) {
        $this->pageFactory = $pageFactory;
    }

    /**
     * @throws LocalizedException
     */
    public function getPageList()
    {
        $collection = $this->pageFactory->create();
        $jsonArr = [];
        $count = 0;
        foreach ($collection as $page) {
            $jsonArr[$count] = $page->getData();
            $count++;
        }
        return $jsonArr;
    }
}
