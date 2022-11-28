<?php
namespace Muffin\MegaMenu\Plugin;

use Magento\Catalog\Api\CategoryManagementInterface;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Helper\Category;

class Topmenu
{
    protected CategoryManagementInterface $categoryManagement;
    public Category $helperData;

    protected $nodeFactory;

    protected $urlBuilder;

    public function __construct(
        CategoryManagementInterface $categoryManagement,
        Category $helperData,
        NodeFactory $nodeFactory,
        UrlInterface $urlBuilder
    ) {
        $this->categoryManagement = $categoryManagement;
        $this->helperData = $helperData;
        $this->nodeFactory = $nodeFactory;
        $this->urlBuilder = $urlBuilder;
    }
    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $menuNode = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray("Custom Menu", "custom-menu"),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree(),
            ]
        );


        $menuNode->addChild(
            $this->nodeFactory->create(
                [
                    'data' => $this->getNodeAsArray("Custom Menu - Child Menu", "child-menu"),
                    'idField' => 'id',
                    'tree' => $subject->getMenu()->getTree(),
                ]
            )
        );
        $subject->getMenu()->addChild($menuNode);
    }
    protected function getNodeAsArray($name, $id)
    {
        $url = $this->urlBuilder->getUrl($id);
        return [
            'name' => __($name),
            'id' => $id,
            'url' => $url,
            'has_active' => false,
            'is_active' => false,
        ];
    }
}
