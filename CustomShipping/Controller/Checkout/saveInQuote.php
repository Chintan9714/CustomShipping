<?php

namespace Chintan\CustomShipping\Controller\Checkout;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\LayoutFactory;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Checkout\Model\Session;
use Magento\Quote\Model\QuoteRepository;

class saveInQuote extends Action
{
    protected $resultForwardFactory;
    protected $layoutFactory;
    protected $cart;

    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\JsonFactory    $resultJsonFactory,
        ForwardFactory $resultForwardFactory,
        LayoutFactory $layoutFactory,
        Cart $cart,
        Session $checkoutSession,
        QuoteRepository $quoteRepository
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->layoutFactory = $layoutFactory;
        $this->cart = $cart;
        $this->checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;
        $this->resultJsonFactory = $resultJsonFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        $checkVal = '';
        $result  = $this->resultJsonFactory->create();
        $checkVal = $this->getRequest()->getParam('selectedChoice');
       
        $countryArr = array();

        $countryArr = array(
                "usa" => array("select a value","New Yourk", "Los Angeles", "California"),
                "choose a country" => array("select a value","choose a country"),
                "india" => array("select a value","Mumbai", "New Delhi", "Bangalore"),
                "uk" => array("select a value","London", "Manchester", "Liverpool")
            );
        if($checkVal != '')
        {
            //echo "<label>City:</label>";
            //echo "<select name='state'>";
            foreach($countryArr[$checkVal] as $value)
            {
               echo "<option>" .$value. "</option>";
            }
            //echo "</select>";
        } 

         $state = $this->getRequest()->getParam('state');
          $country = $this->getRequest()->getParam('country');
        $quoteId = $this->checkoutSession->getQuoteId();
        $quote = $this->quoteRepository->get($quoteId);
        $quote->setCountry($country);
        $quote->setStates($state);
        $quote->save();



        //return $this;
        //$quoteId = $this->checkoutSession->getQuoteId();
        //$quote = $this->quoteRepository->get($quoteId);
        //$quote->setAgree($checkVal);
        //$quote->save();

    }
}