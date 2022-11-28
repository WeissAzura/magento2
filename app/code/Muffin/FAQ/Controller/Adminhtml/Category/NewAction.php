<?php

namespace Muffin\FAQ\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;


class NewAction extends Action
{
    public function execute()
    {
        $this->_forward('Edit');
    }
}
