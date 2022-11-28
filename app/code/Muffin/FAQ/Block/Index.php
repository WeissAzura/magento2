<?php

namespace Muffin\FAQ\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Muffin\FAQ\Helper\Data;

class Index extends Template
{
    protected Data $dataHelper;
    protected RequestInterface $request;
    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        Data $dataHelper,
        array $data = [],
    ) {
        $this->request = $request;
        $this->dataHelper = $dataHelper;
        parent::__construct($context, $data);
    }
    public function getCategoryCollection()
    {
        return $this->dataHelper->getActiveCategory();
    }
    public function getAnsweredQuestion()
    {
        return $this->dataHelper->getQuestionCollection($this->getData('category_id'));
    }
    public function getPageType()
    {
        return $this->request->getParam('info');
    }
    public function getQuestion()
    {
        return $this->dataHelper->getQuestion();
    }
    public function getCategory()
    {
        return $this->dataHelper->getCategory();
    }
}
