<?php

namespace Muffin\Helpdesk\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Ticket extends AbstractDb
{

    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('muffin_helpdesk_ticket', 'ticket_id');
    }
}
