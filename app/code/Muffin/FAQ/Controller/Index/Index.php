<?php

namespace Muffin\FAQ\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;


class Index implements HttpGetActionInterface
{
    protected UrlInterface $urlBuilder;
    protected PageFactory $resultPageFactory;
    protected RequestInterface $request;
    public function __construct(
        PageFactory $resultPageFactory,
        UrlInterface $urlBuilder,
        RequestInterface $request,
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set('FAQs');
        return $resultPage;
    }
}
