<?php

namespace Muffin\FAQ\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Muffin\FAQ\Model\QuestionFactory;

class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Muffin_FAQ::question';
    protected $resultPageFactory;
    protected $questionFactory;
    protected $_coreRegistry;
    /**
     * Edit constructor.
     *
     * @param PageFactory $resultPageFactory
     * @param QuestionFactory $questionFactory
     * @param Registry $registry
     * @param Context $context
     */
    public function __construct(
        PageFactory $resultPageFactory,
        QuestionFactory $questionFactory,
        Registry $registry,
        Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('question_id');
        $question = $this->questionFactory->create();

        if ($id) {
            $question->load($id);
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Muffin_FAQ::question');
        $resultPage->getConfig()->getTitle()
            ->prepend($question->getData('question_id') ? $question->getData('question') : 'New Question');
        return $resultPage;
    }
}
