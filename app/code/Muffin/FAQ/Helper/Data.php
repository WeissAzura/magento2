<?php
namespace Muffin\FAQ\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Muffin\FAQ\Model\CategoryFactory;
use Muffin\FAQ\Model\QuestionFactory;

class Data extends AbstractHelper
{
    protected UrlInterface $urlBuilder;
    const CONFIG_MODULE_PATH = 'muffin_faq';
    /**
     * @var CategoryFactory
     */
    public CategoryFactory $categoryFactory;

    /**
     * @var QuestionFactory
     */
    public QuestionFactory $questionFactory;
    /**
     * @var DateTime
     */
    protected DateTime $date;

    /**
     * @var HttpContext
     */
    protected HttpContext $httpContext;

    /**
     * Data constructor.
     *
     * @param DateTime $date
     * @param Context $context
     * @param HttpContext $httpContext
     */
    public function __construct(
        DateTime $date,
        Context $context,
        HttpContext $httpContext,
        CategoryFactory $categoryFactory,
        QuestionFactory $questionFactory,
        UrlInterface $urlBuilder
    ) {
        $this->date = $date;
        $this->urlBuilder = $urlBuilder;
        $this->categoryFactory = $categoryFactory;
        $this->questionFactory = $questionFactory;
        $this->httpContext = $httpContext;
        parent::__construct($context);
    }
    public function getConfig()
    {
        $config = $this->scopeConfig->getValue(self::CONFIG_MODULE_PATH, ScopeInterface::SCOPE_STORE);
        return $config['general'];
    }
    public function getActiveCategory()
    {
        return $this->categoryFactory->create()->getCollection()->addFieldToFilter('status', 1);
    }
    public function getQuestionCollection($id = null)
    {
        return $this->questionFactory->create()->getCollection()->addFieldToFilter('category_id', $id)->addFieldToFilter('status', 1);
    }

    public function getType($url_key)
    {
        $cat = $this->categoryFactory->create()->getCollection()->addFieldToFilter('url_key', $url_key);
        $quest = $this->questionFactory->create()->getCollection()->addFieldToFilter('url_key', $url_key);
        if ($cat->getSize() > 0) {
            foreach ($cat as $item) {
                return [
                    'name' => $item->getData('category'),
                    'type' => "category",
                    'id' => $item->getData('category_id')
                ];
            }
        }
        if ($quest->getSize() > 0) {
            foreach ($quest as $item) {
                return [
                    'name' => $item->getData('question'),
                    'type' => "question",
                    'id' => $item->getData('question_id')
                ];
            }
        }
    }
    public function getQuestion()
    {
        return $this->questionFactory->create();
    }
    public function getCategory()
    {
        return $this->categoryFactory->create();
    }
}
