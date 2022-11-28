<?php
namespace Muffin\Helpdesk\Controller\Ticket;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Muffin\Helpdesk\Controller\Ticket;
use Muffin\Helpdesk\Model\TicketFactory;

class Save extends Ticket
{
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $scopeConfig;
    protected $storeManager;
    protected $formKeyValidator;
    protected $dateTime;
    protected $ticketFactory;
    public function __construct(
        Context $context,
        Session $customerSession,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Validator $formKeyValidator,
        DateTime $dateTime,
        TicketFactory $ticketFactory
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->dateTime = $dateTime;
        $this->ticketFactory = $ticketFactory;
        $this->messageManager = $context->getMessageManager();
        parent::__construct($context, $customerSession);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $resultRedirect->setRefererUrl();
        }
        $title = $this->getRequest()->getParam('title');
        $severity = $this->getRequest()->getParam('severity');
        try {
            /* Save ticket */
            $ticket = $this->ticketFactory->create();
            $ticket->setCustomerId($this->customerSession->
            getCustomerId());
            $ticket->setTitle($title);
            $ticket->setSeverity($severity);
            $ticket->setCreatedAt($this->dateTime->formatDate(true));
            $ticket->setStatus(\Muffin\Helpdesk\Model\Ticket::STATUS_OPENED);
            $ticket->save();
            $customer = $this->customerSession->getCustomerData();
            /* Send email to store owner */
            $storeScope = ScopeInterface::SCOPE_STORE;
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->scopeConfig->getValue('muffin_helpdesk/email_template/store_owner', $storeScope))
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId(),
                    ]
                )
                ->setTemplateVars(['ticket' => $ticket])
                ->setFrom([
                        'name' => $customer->getFirstname() . ' ' . $customer->getLastname(),
                        'email' => $customer->getEmail()
                ])
                ->addTo($this->scopeConfig->getValue('trans_email/ident_general/email', $storeScope))
                ->getTransport();
            /*
             * $transport->sendMessage();
             */
            $this->inlineTranslation->resume();
            $this->messageManager->addSuccess(__('Ticket successfully created.'));
        } catch (Exception $e) {
            $this->messageManager->addError(__('Error occurred during ticket creation.'));
        }
        return $resultRedirect->setRefererUrl();
    }
}
