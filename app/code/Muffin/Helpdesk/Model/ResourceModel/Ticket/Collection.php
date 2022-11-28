<?php

namespace Muffin\Helpdesk\Model\ResourceModel\Ticket;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Muffin\Helpdesk\Model\Ticket', 'Muffin\Helpdesk\Model\ResourceModel\Ticket');
    }
}
