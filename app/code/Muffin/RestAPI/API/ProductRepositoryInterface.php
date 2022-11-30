<?php
namespace Muffin\RestAPI\API;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchResultsInterface;
interface ProductRepositoryInterface
{
    /**
     * Return a filtered product.
     *
     * @param int $id
     * @return ResponseItemInterface
     * @throws NoSuchEntityException
     */
    public function getItem(int $id);
    /**
     * Return a filtered product by category ID.
     *
     * @param int $id
     * @return ResponseItemInterface
     * @throws NoSuchEntityException
     */
    public function getItemByCategory(int $id);
    /**
     * Return a filtered product list.
     *
     * @return ResponseItemInterface
     * @throws NoSuchEntityException
     */
    public function getList();
    /**
     * Return a filtered product list.
     *
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getListBySearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
    /**
     * Set descriptions for the products.
     *
     * @param RequestItemInterface[] $products
     * @return void
     */
    public function setDescription(array $products);
}
