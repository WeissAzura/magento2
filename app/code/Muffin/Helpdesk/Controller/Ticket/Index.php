<?php
namespace Muffin\Helpdesk\Controller\Ticket;

use Magento\Framework\Controller\ResultFactory;
use Muffin\Helpdesk\Controller\Ticket;

class Index extends Ticket
{
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
