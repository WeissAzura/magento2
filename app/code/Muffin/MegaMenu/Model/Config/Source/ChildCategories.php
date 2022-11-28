<?php
namespace Muffin\MegaMenu\Model\Config\Source;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class ChildCategories implements OptionSourceInterface
{
    protected $categoryRepository;
    protected RequestInterface $request;
    public function __construct(
        CategoryRepository $categoryRepository,
        RequestInterface $request,
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->request = $request;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function toOptionArray()
    {
        $parentID = $this->request->getParam('info')['ID'];
        $options = [['label' => '', 'value' => '']];
        $categories= $this->categoryRepository->get($parentID)->getChildrenCategories();
        foreach ($categories as $item) {
            $options[] = ['value' => $item->getData('entity_id'), 'label' => $item->getData('name')];
        }
        return $options;
    }
}
