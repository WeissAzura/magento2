<?php
namespace Muffin\Helpdesk\Model\Ticket\Grid;

use Magento\Framework\Option\ArrayInterface;
use Muffin\Helpdesk\Model\Ticket;

class Severity implements ArrayInterface
{
    public function toOptionArray()
    {
        return Ticket::getSeveritiesOptionArray();
    }
}
