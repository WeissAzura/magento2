<?php

namespace Muffin\FAQ\Controller;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Muffin\FAQ\Helper\Data;

class Router implements RouterInterface
{
    protected RequestInterface $request;
    protected Data $dataHelper;
    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * Router constructor.
     *
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     */
    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        Data $dataHelper,
        RequestInterface $request
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
        $this->dataHelper = $dataHelper;
        $this->request = $request;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        if ($this->dataHelper->getConfig()['enabled'] == 1) {
            $prefix_url = $this->dataHelper->getConfig()['routerName'];
            $identifier = array_filter(explode('/', $this->request->getPathInfo()));
            if (in_array($prefix_url, $identifier) && count($identifier) == 1) {
                $request->setModuleName('faq');
                $request->setControllerName('index');
                $request->setActionName('index');
                return $this->actionFactory->create(Forward::class);
            }
            if (in_array($prefix_url, $identifier) && count($identifier) == 2) {
                foreach ($identifier as $url_key) {
                    if ($url_key != $prefix_url) {
                        $this->request->setParams(['info' => $this->dataHelper->getType($url_key)]);
                        $request->setModuleName('faq');
                        $request->setControllerName('index');
                        $request->setActionName('info');
                        return $this->actionFactory->create(Forward::class);
                    }
                }
            }
        }
        return null;
    }
}
