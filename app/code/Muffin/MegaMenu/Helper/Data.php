<?php
namespace Muffin\MegaMenu\Helper;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    const CONFIG_MODULE_PATH = '';
    protected CategoryRepository $categoryRepository;
    protected UrlInterface $urlBuilder;
    protected DateTime $date;
    protected HttpContext $httpContext;
    protected Session $customerSession;
    protected StoreManagerInterface $_storeManager;

    public function __construct(
        DateTime $date,
        CategoryRepository $categoryRepository,
        StoreManagerInterface $storeManager,
        Session $customerSession,
        Context $context,
        HttpContext $httpContext,
        UrlInterface $urlBuilder
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->_storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->date = $date;
        $this->urlBuilder = $urlBuilder;
        $this->httpContext = $httpContext;
        parent::__construct($context);
    }
}
