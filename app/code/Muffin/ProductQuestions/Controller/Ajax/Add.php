<?php
namespace Muffin\ProductQuestions\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Muffin\ProductQuestions\Model\QuestionFactory;
use Muffin\ProductQuestions\Helper\Data;

class Add extends Action
{
    protected Data $dataHelper;
    protected DateTime $date;
    protected QuestionFactory $questionFactory;
    protected Context $context;
    protected JsonFactory $resultJsonFactory;
    public function __construct(
        JsonFactory $resultJsonFactory,
        Data $dataHelper,
        DateTime $date,
        QuestionFactory $questionFactory,
        Context $context,
    ) {
        $this->dataHelper = $dataHelper;
        $this->date = $date;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $date = $this->date->gmtDate();
        $data = $this->getRequest()->getParams();
        $question = [
            'question' => $data['question'],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'product_id' => $data['product_id'],
            'status' => $this->dataHelper->getConfig()['submode'],
            'updated_at' => $date,
            'created_at' => $date,
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
