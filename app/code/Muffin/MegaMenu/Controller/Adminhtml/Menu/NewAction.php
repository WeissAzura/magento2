<?php

namespace Muffin\MegaMenu\Controller\Adminhtml\Menu;

use Magento\Backend\App\Action;


class NewAction extends Action
{
    public function execute()
    {
        $this->_forward('Edit');
    }
}
