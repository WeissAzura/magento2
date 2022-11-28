<?php
namespace Muffin\FAQ\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Muffin\FAQ\Model\QuestionFactory;

class Add extends Action
{
    protected QuestionFactory $questionFactory;
    protected Context $context;
    public function __construct(
        JsonFactory $resultJsonFactory,
        QuestionFactory $questionFactory,
        Context $context,
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $url_key = str_replace(" ","-", $data['question']);
        $question = [
            'question' => $data['question'],
            'url_key' => $url_key,
            'category_id' => $data['category_id'],
        ];
        try {
            $object = $this->questionFactory->create()->setData($question);
            $object->save();
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
        }
        $this->messageManager->addSuccessMessage("Question was sent successfully");
        $result = $this->resultJsonFactory->create();
        $result->setData(["message" => "Success", "status" => 'ok']);
        return $result;
    }
}
