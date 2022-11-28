<?php

namespace Muffin\ProductQuestions\Model;

use Magento\Framework\Model\AbstractModel;
use Muffin\ProductQuestions\Model\ResourceModel\Question as ResourceModel;

class Question extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_pq_question_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
