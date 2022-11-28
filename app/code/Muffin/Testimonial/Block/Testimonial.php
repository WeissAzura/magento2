<?php

namespace Muffin\Testimonial\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Muffin\Testimonial\Model\TestimonialFactory;

class Testimonial extends Template
{
    protected RequestInterface $request;
    protected TestimonialFactory $testimonialFactory;
    public function __construct(
        TestimonialFactory $testimonialFactory,
        Template\Context $context,
        RequestInterface $request,
        array $data = [],
    ) {
        $this->testimonialFactory = $testimonialFactory;
        $this->request = $request;
        parent::__construct($context, $data);
    }

    public function getTestimonyCollection()
    {
        return $this->testimonialFactory->create()->getCollection();
    }
}
