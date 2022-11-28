<?php

namespace Muffin\Helpdesk\Controller\Adminhtml\Ticket;

use Muffin\Helpdesk\Controller\Adminhtml\Ticket;

class Index extends Ticket
{
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('grid');
            return $resultForward;
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Muffin_Helpdesk::ticket_manage');
        $resultPage->getConfig()->getTitle()->prepend(__('Tickets'));
        $resultPage->addBreadcrumb(__('Tickets'), __('Tickets'));
        $resultPage->addBreadcrumb(__('Manage Tickets'), __('Manage Tickets'));
        return $resultPage;
    }
}
