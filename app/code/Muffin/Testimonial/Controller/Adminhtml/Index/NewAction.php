<?php

namespace Muffin\Testimonial\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;


class NewAction extends Action
{
    public function execute()
    {
        $this->_forward('Edit');
    }
}
