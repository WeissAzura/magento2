<?php
namespace Muffin\RestAPI\API;

use Magento\Framework\Exception\NoSuchEntityException;

interface PageRepositoryITF
{
    /**
     * Return a page list.
     * @return array[]
     * @throws NoSuchEntityException
     */
    public function getPageList();
}
