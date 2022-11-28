<?php
namespace Muffin\FAQ\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\UrlInterface;
use Muffin\FAQ\Helper\Data;

class Topmenu implements ObserverInterface
{
    protected Data $dataHelper;
    protected UrlInterface $urlBuilder;
    public function __construct(
        UrlInterface $urlBuilder,
        Data $dataHelper
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->dataHelper = $dataHelper;
    }
    public function execute(EventObserver $observer)
    {
        $menu = $observer->getMenu();
        $tree = $menu->getTree();
        $data = [
            'name'      => __('FAQ'),
            'id'        => 'faq_page',
            'url'       => $this->urlBuilder->getUrl($this->dataHelper->getConfig()['routerName']),
            'is_active' => false,
        ];
        $node = new Node($data, 'id', $tree, $menu);
        $menu->addChild($node);
    }
}
