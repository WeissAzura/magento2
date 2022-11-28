<?php

namespace Muffin\ProductQuestions\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_pq_question_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('muffin_pq_question', 'question_id');
        $this->_useIsObjectNew = true;
    }
}
