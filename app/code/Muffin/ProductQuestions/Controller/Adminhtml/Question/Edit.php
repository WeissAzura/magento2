<?php

namespace Muffin\ProductQuestions\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Muffin\ProductQuestions\Model\QuestionFactory;
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Muffin_PQ::question';
    protected $resultPageFactory;
    protected $questionFactory;

    public function __construct(
        PageFactory $resultPageFactory,
        QuestionFactory $questionFactory,
        Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
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
        $resultPage->setActiveMenu('Muffin_PQ::question');
        $resultPage->getConfig()->getTitle()
            ->prepend($question->getData('question'));
        return $resultPage;
    }
}
