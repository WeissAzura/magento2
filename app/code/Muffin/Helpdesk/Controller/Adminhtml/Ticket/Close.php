<?php namespace Muffin\Helpdesk\Controller\Adminhtml\Ticket;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Muffin\Helpdesk\Controller\Adminhtml\Ticket;
use Muffin\Helpdesk\Model\TicketFactory;

class Close extends Ticket
{
    protected $ticketFactory;
    protected $customerRepository;
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $scopeConfig;
    protected $storeManager;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        TicketFactory $ticketFactory,
        CustomerRepositoryInterface $customerRepository,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->ticketFactory = $ticketFactory;
        $this->customerRepository = $customerRepository;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        parent::__construct($context, $resultPageFactory, $resultForwardFactory);
    }
    public function execute()
    {
        $ticketId = $this->getRequest()->getParam('id');
        $ticket = $this->ticketFactory->create()->load($ticketId);
        if ($ticket && $ticket->getId()) {
            try {
                $ticket->setStatus(\Muffin\Helpdesk\Model\Ticket::STATUS_CLOSED);
                $ticket->save();
                $this->messageManager->addSuccess(__('Ticket successfully closed.'));
                /* Send email to customer */
                /*
                $customer = $this->customerRepository->getById($ticket->getCustomerId());
                $storeScope = ScopeInterface::SCOPE_STORE;
                $transport = $this->transportBuilder
                    ->setTemplateIdentifier($this->scopeConfig->getValue('muffin_helpdesk/email_template/customer', $storeScope))
                    ->setTemplateOptions(
                        [
                            'area' => Area::AREA_ADMINHTML,
                            'store' => $this->storeManager->getStore()->getId(),
                        ]
                    )
                    ->setTemplateVars([
                                'ticket' => $ticket,
                                'customer_name' => $customer->getFirstname()
                    ])
                    ->setFrom([
                        'name' => $this->scopeConfig->getValue('trans_email/ident_general/name', $storeScope),
                        'email' => $this->scopeConfig->getValue('trans_email/ident_general/email', $storeScope)
                    ])
                    ->addTo($customer->getEmail())
                    ->getTransport();

                 $transport->sendMessage();
                 */
                $this->inlineTranslation->resume();
                $this->messageManager->addSuccess(__('Customer notified via email.'));
            } catch (Exception $e) {
                $this->messageManager->addError(__('Error with closing ticket action.'));
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');
        return $resultRedirect;
    }
}
