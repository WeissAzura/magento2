<?php
namespace Muffin\AjaxCart\Controller\Cart;

use Magento\Catalog\Api\ProductRepositoryInterfaceFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Muffin\AjaxCart\Helper\Data;
use Magento\Catalog\Helper\Image;

class Add extends Action implements HttpPostActionInterface
{
    protected ProductRepositoryInterfaceFactory $productRepositoryFactory;
    protected Data $helperData;
    protected Cart $helperCart;
    protected Context $context;
    protected Image $imageBuilder;
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        Data $helperData,
        Image $imageBuilder,
        ProductRepositoryInterfaceFactory $productRepositoryFactory
    ) {
        $this->imageBuilder = $imageBuilder;
        $this->helperData = $helperData;
        $this->productRepositoryFactory = $productRepositoryFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $product = $this->productRepositoryFactory->create()->getById($data['product']);
        $this->helperData->addProductToCart($data['product']);
        $name = $product->getData('name');
        $price = $product->getData('price');
        $thumbnail = $this->imageBuilder->init($product, 'product_thumbnail_image')->getUrl();
        $result = $this->resultJsonFactory->create();
        $result->setData(["message" => "Success", "status" => 'ok', 'image' => $thumbnail, 'name' => $name, 'price' => $price]);
        $this->messageManager->addSuccessMessage($product->getData('name') . " added to cart");
        return $result;
    }
}
