<?php
namespace Muffin\Helpdesk\Block\Adminhtml\Ticket\Grid\Renderer;

use Muffin\Helpdesk\Model\TicketFactory;
use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;

class Status extends AbstractRenderer
{
    protected $ticketFactory;
    public function __construct(
        Context $context,
        TicketFactory $ticketFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->ticketFactory = $ticketFactory;
    }
    public function render(DataObject $row)
    {
        $ticket = $this->ticketFactory->create()->load($row->getId());
        if ($ticket && $ticket->getId()) {
            return $ticket->getStatusAsLabel();
        }
        return '';
    }
}
