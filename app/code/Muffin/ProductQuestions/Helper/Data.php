<?php
namespace Muffin\ProductQuestions\Helper;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Muffin\ProductQuestions\Model\QuestionFactory;

class Data extends AbstractHelper
{
    const CONFIG_MODULE_PATH = 'muffin_pq';
    protected UrlInterface $urlBuilder;
    protected QuestionFactory $questionFactory;
    protected DateTime $date;
    protected HttpContext $httpContext;
    protected $customerSession;

    public function __construct(
        DateTime $date,
        Session $customerSession,
        Context $context,
        HttpContext $httpContext,
        QuestionFactory $questionFactory,
        UrlInterface $urlBuilder
    ) {
        $this->customerSession = $customerSession;
        $this->date = $date;
        $this->urlBuilder = $urlBuilder;
        $this->questionFactory = $questionFactory;
        $this->httpContext = $httpContext;
        parent::__construct($context);
    }
    public function getConfig()
    {
        $config = $this->scopeConfig->getValue(self::CONFIG_MODULE_PATH, ScopeInterface::SCOPE_STORE);
        return $config['general'];
    }

    public function getQuestionCollection()
    {
        return $this->questionFactory->create()->getCollection()->addFieldToFilter('status', 1);
    }
}
