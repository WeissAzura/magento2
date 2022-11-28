<?php

namespace Muffin\ProductQuestions\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Muffin\ProductQuestions\Model\Question as Model;
use Muffin\ProductQuestions\Model\ResourceModel\Question as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'muffin_pq_question_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
