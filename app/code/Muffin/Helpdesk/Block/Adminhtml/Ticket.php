<?php
namespace Muffin\Helpdesk\Block\Adminhtml;
use Magento\Backend\Block\Widget\Grid\Container;

class Ticket extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml';
        $this->_blockGroup = 'Muffin_Helpdesk';
        $this->_headerText = __('Tickets');
        parent::_construct();
        $this->removeButton('add');
    }
}
