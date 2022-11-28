<?php
namespace Muffin\Testimonial\Helper;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\UrlInterface;

class Data extends AbstractHelper
{
    protected UrlInterface $urlBuilder;
    protected DateTime $date;
    protected HttpContext $httpContext;
    protected ProductRepositoryInterface $productRepository;

    public function __construct(
        DateTime $date,
        Context $context,
        ProductRepositoryInterface $productRepository,
        HttpContext $httpContext,
        UrlInterface $urlBuilder
    ) {
        $this->productRepository = $productRepository;
        $this->date = $date;
        $this->urlBuilder = $urlBuilder;
        $this->httpContext = $httpContext;
        parent::__construct($context);
    }
    public function getAttribute($id, $code)
    {
        return $this->productRepository->getById($id)->getAttributeText($code);
    }
}
