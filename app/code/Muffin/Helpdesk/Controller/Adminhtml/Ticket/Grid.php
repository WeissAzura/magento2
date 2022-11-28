<?php
namespace Muffin\Helpdesk\Controller\Adminhtml\Ticket;

use Muffin\Helpdesk\Controller\Adminhtml\Ticket;

class Grid extends Ticket
{
    public function execute()
    {
        $this->_view->loadLayout(false);
        $this->_view->renderLayout();
    }
}
