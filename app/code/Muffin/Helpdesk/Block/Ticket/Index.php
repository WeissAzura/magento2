<?php
namespace Muffin\Helpdesk\Block\Ticket;

use Magento\Customer\Model\Session;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Muffin\Helpdesk\Model\TicketFactory;

class Index extends Template
{
    /**
     * @var DateTime
     */
    protected $dateTime;
    /**
     * @var Session
     */
    protected $customerSession;
    /**
     * @var TicketFactory
     */
    protected $ticketFactory;
    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        DateTime $dateTime,
        Session $customerSession,
        TicketFactory $ticketFactory,
        array $data = []
    ) {
        $this->dateTime = $dateTime;
        $this->customerSession = $customerSession;
        $this->ticketFactory = $ticketFactory;
        parent::__construct($context, $data);
    }
    /**
     * @return \Muffin\Helpdesk\Model\ResourceModel\Ticket\Collection
     */
    public function getTickets()
    {
        return $this->ticketFactory
                ->create()
                ->getCollection()
                ->addFieldToFilter('customer_id', $this->customerSession->getCustomerId());
    }
    public function getSeverities()
    {
        return \Muffin\Helpdesk\Model\Ticket::getSeveritiesOptionArray();
    }
}
