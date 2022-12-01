<?php
namespace Muffin\RestAPI\Model\API;

use Magento\Framework\Exception\LocalizedException;
use Muffin\RestAPI\API\PageRepositoryITF;
use Muffin\RestAPI\Model\PageCollectionFactory;

/**
 * Class ProductRepository
 */
class PageRepository implements PageRepositoryITF
{
    protected PageCollectionFactory $pageFactory;
    public function __construct(
        PageCollectionFactory $pageFactory,
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
        foreach ($collection as $page) {
            $jsonArr[] = $page->getData();
        }
        return $jsonArr;
    }
}
