<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
  class Magebuzz_Advancedreview_Block_Form extends Mage_Review_Block_Form
  {
      public function __construct() {
      $customerSession = Mage::getSingleton('customer/session');
      $data =  Mage::getSingleton('review/session')->getFormData(true);
      $data = new Varien_Object($data);
      // add logged in customer name as nickname
      if (!$data->getNickname()) {
        $customer = $customerSession->getCustomer();
        if ($customer && $customer->getId()) {
          $data->setNickname($customer->getFirstname());
        }
      }
      $this->setAllowWriteReviewFlag($customerSession->isLoggedIn() || Mage::helper('review')->getIsGuestAllowToWrite());
      if (!$this->getAllowWriteReviewFlag) {
        $this->setLoginLink(
        Mage::getUrl('customer/account/login/', array(
        Mage_Customer_Helper_Data::REFERER_QUERY_PARAM_NAME => Mage::helper('core')->urlEncode(
        Mage::getUrl('*/*/*', array('_current' => true)) .
        '#review-form')
              )
            )
          );
        }
        if(Mage::getStoreConfig('advancedreview/general/enabled_review')==1) {
          $this->setTemplate('advancedreview/product/review.phtml')
          ->assign('data', $data)
          ->assign('messages', Mage::getSingleton('review/session')->getMessages(true)); 
        }else {
                  $this->setTemplate('review/form.phtml')
            ->assign('data', $data)
            ->assign('messages', Mage::getSingleton('review/session')->getMessages(true));
        }  
    }
  }

