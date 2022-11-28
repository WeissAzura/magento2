<?php

namespace Muffin\ProductQuestions\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Muffin\ProductQuestions\Helper\Data;
use Magento\Customer\Model\Session;

class QuestionTab extends Template
{
    protected $customerSession;
    protected Data $dataHelper;
    protected RequestInterface $request;
    public function __construct(
        Data $dataHelper,
        Session $customerSession,
        Template\Context $context,
        RequestInterface $request,
        array $data = [],
    ) {
        $this->customerSession = $customerSession;
        $this->request = $request;
        $this->dataHelper = $dataHelper;
        parent::__construct($context, $data);
    }

    /**
     * @throws LocalizedException
     */
    public function getCustomerInfo()
    {
        return [
            'id' => $this->customerSession->getCustomer()->getId(),
            'email' => $this->customerSession->getCustomer()->getEmail(),
            'name' => $this->customerSession->getCustomer()->getName(),
        ];
    }
    public function getQuestion()
    {
        return $this->dataHelper->getQuestionCollection();
    }
}
