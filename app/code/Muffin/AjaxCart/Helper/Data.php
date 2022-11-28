<?php
namespace Muffin\AjaxCart\Helper;

use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Stdlib\DateTime\DateTime;

class Data extends AbstractHelper
{
    protected $formKey;
    protected $cart;
    protected $product;
    protected DateTime $date;
    protected HttpContext $httpContext;

    public function __construct(
        DateTime $date,
        Context $context,
        HttpContext $httpContext,
        FormKey $formKey,
        Cart $cart,
        Product $product,
    ) {
        $this->date = $date;
        $this->httpContext = $httpContext;
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->product = $product;
        parent::__construct($context);
    }
    public function addProductToCart($productId)
    {
        $params = [
            'form_key' => $this->formKey->getFormKey(),
            'product' => $productId,
            'qty'   => 1,
        ];
        $product = $this->product->load($productId);
        $this->cart->addProduct($product, $params);
        $this->cart->save();
    }
}
