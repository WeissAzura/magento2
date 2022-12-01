<?php
namespace Muffin\RestAPI\Model\API;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product\Attribute\Repository;
use Magento\Catalog\Model\ResourceModel\Product\Action;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Store\Model\StoreManagerInterface;
use Muffin\RestAPI\API\ProductRepositoryInterface;
use Muffin\RestAPI\API\RequestItemInterface;
use Muffin\RestAPI\API\RequestItemInterfaceFactory;
use Muffin\RestAPI\API\ResponseItemInterface;
use Muffin\RestAPI\API\ResponseItemInterfaceFactory;

/**
 * Class ProductRepository
 */
class ProductRepository implements ProductRepositoryInterface
{
    protected SearchCriteriaBuilder $searchCriteriaBuilder;
    protected SearchResultsInterface $searchResults;
    protected Repository $attributeRepository;
    protected Request $request;
    /**
     * @var Action
     */
    private $productAction;
    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;
    /**
     * @var RequestItemInterfaceFactory
     */
    private $requestItemFactory;
    /**
     * @var ResponseItemInterfaceFactory
     */
    private $responseItemFactory;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @param Action $productAction
     * @param CollectionFactory $productCollectionFactory
     * @param RequestItemInterfaceFactory $requestItemFactory
     * @param ResponseItemInterfaceFactory $responseItemFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Repository $attributeRepository,
        SearchResultsInterface $searchResults,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Action $productAction,
        Request $request,
        CollectionFactory $productCollectionFactory,
        RequestItemInterfaceFactory $requestItemFactory,
        ResponseItemInterfaceFactory $responseItemFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->searchResults = $searchResults;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->attributeRepository = $attributeRepository;
        $this->request = $request;
        $this->productAction = $productAction;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->requestItemFactory = $requestItemFactory;
        $this->responseItemFactory = $responseItemFactory;
        $this->storeManager = $storeManager;
    }
    /**
     * {@inheritDoc}
     *
     * @param int $id
     * @return ResponseItemInterface
     * @throws NoSuchEntityException
     */
    public function getItem(int $id) : mixed
    {
        $collection = $this->getProductCollection()
            ->addAttributeToFilter('entity_id', ['eq' => $id]);
        /** @var ProductInterface $product */
        $product = $collection->getFirstItem();
        if (!$product->getId()) {
            throw new NoSuchEntityException(__('Product not found'));
        }
        return $this->getResponseItemFromProduct($product);
    }
    /**
     * {@inheritDoc}
     *
     * @param int $id
     * @return ResponseItemInterface
     * @throws NoSuchEntityException
     */
    public function getItemByCategory(int $id) : mixed
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $id]);
        /** @var ProductInterface $product */
        $product = $collection->getFirstItem();
        if (!$product->getId()) {
            throw new NoSuchEntityException(__('No product was found'));
        }
        return $this->getResponseItemFromProductCollection($collection);
    }
    public function getOptionIdbyAttributeCodeandLabel($attr_code, $optionText)
    {
        $attribute =$this->attributeRepository->get($attr_code);
        $optionId = $attribute->getSource()->getOptionId($optionText);
        return $optionId;
    }
    public function getList()
    {
        $requestParams = $this->request->getParams();
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect(['name', 'price', 'size', 'color']);
        if (isset($requestParams['priceFrom'])) {
            $collection->addAttributeToFilter('price', ['gteq' => $requestParams['priceFrom']]);
        }
        if (isset($requestParams['priceTo'])) {
            $collection->addAttributeToFilter('price', ['lteq' => $requestParams['priceTo']]);
        }
        if (isset($requestParams['name'])) {
            $collection->addAttributeToFilter('name', ['like' => '%' . $requestParams['name'] . '%']);
        }
        if (isset($requestParams['size'])) {
            $collection->addAttributeToFilter('size', ['like' => '%' . $this->getOptionIdbyAttributeCodeandLabel('size', $requestParams['size']) . '%']);
        }
        if (isset($requestParams['color'])) {
            $collection->addAttributeToFilter('color', ['like' => '%' . $this->getOptionIdbyAttributeCodeandLabel('color', $requestParams['color']) . '%']);
        }
        /** @var ProductInterface $product */
        $product = $collection->getFirstItem();
        if (!$product->getId()) {
            throw new NoSuchEntityException(__('No product was found'));
        }
        return $this->getResponseItemFromProductCollection($collection);
    }
    public function getListBySearchCriteria(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->productCollectionFactory->create();
        $this->searchResults->setSearchCriteria($searchCriteria);
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $this->searchResults->setTotalCount($collection->getSize());
        $sortOrdersData = $searchCriteria->getSortOrders();
        if ($sortOrdersData) {
            foreach ($sortOrdersData as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $this->searchResults->setItems($collection->toArray());
        return $this->searchResults;
    }
    public function getPageList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {

    }

    public function getResponseItemFromProductCollection($collection)
    {
        $jsonArr = [];
        $count = 0;
        foreach ($collection as $product) {
            $jsonArr[$count] = $product->getData();
            $count++;
        }
        return $jsonArr;
    }
    /**
     * {@inheritDoc}
     *
     * @param RequestItemInterface[] $products
     * @return void
     */
    public function setDescription(array $products) : void
    {
        foreach ($products as $product) {
            $this->setDescriptionForProduct(
                $product->getId(),
                $product->getDescription()
            );
        }
    }
    /**
     * @return Collection
     */
    private function getProductCollection() : mixed
    {
        /** @var Collection $collection */
        $collection = $this->productCollectionFactory->create();
        $collection
            ->addAttributeToSelect(
                [
                    'entity_id',
                    ProductInterface::SKU,
                    ProductInterface::NAME,
                    'description'
                ],
                'left'
            );
        return $collection;
    }
    /**
     * @param ProductInterface $product
     * @return ResponseItemInterface
     */
    private function getResponseItemFromProduct(ProductInterface $product) : mixed
    {
        /** @var ResponseItemInterface $responseItem */
        $responseItem = $this->responseItemFactory->create();
        $responseItem->setId($product->getId())
            ->setSku($product->getSku())
            ->setName($product->getName())
            ->setDescription($product->getDescription());
        return $responseItem;
    }
    /**
     * Set the description for the product.
     *
     * @param int $id
     * @param string $description
     * @return void
     */
    private function setDescriptionForProduct(int $id, string $description) : void
    {
        $this->productAction->updateAttributes(
            [$id],
            ['description' => $description],
            $this->storeManager->getStore()->getId()
        );
    }
}
