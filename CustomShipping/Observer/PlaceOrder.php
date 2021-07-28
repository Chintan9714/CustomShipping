<?php

namespace Chintan\CustomShipping\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteFactory;
use Psr\Log\LoggerInterface;

class PlaceOrder implements ObserverInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $quoteFactory;

    protected $resourceConnection;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */

    public function __construct(
        LoggerInterface $logger,
        QuoteFactory $quoteFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\ResourceConnection $resourceConnection
    ) {
        $this->_logger = $logger;
        $this->quoteFactory = $quoteFactory;
        $this->_customerSession = $customerSession;
        $this->resourceConnection = $resourceConnection;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        $quoteId = $order->getQuoteId();
        $quote  = $this->quoteFactory->create()->load($quoteId);


        $order->setCountry($quote->getCountry());
        $order->setStates($quote->getStates());
        
        $order->save();
    }
}
