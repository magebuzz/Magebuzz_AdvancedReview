<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
  class Magebuzz_Advancedreview_Model_Observer 
{
  const XML_PATH_EMAIL_ADMIN_SENDER             = 'advancedreview/email_setting/email_admin_sender';            
  const XML_PATH_SENT_TO                        = 'advancedreview/email_setting/recipient_admin_email';
  const XML_PATH_EMAIL_TEMPLATE                 = 'advancedreview/email_setting/email_review_template';
  const XML_PATH_EMAIL_CUSTOMER_TEMPLATE        = 'advancedreview/email_setting/email_review_customer_template';               
  const XML_PATH_EMAIL_REPLY_TO                 = 'advancedreview/email_setting/email_reply_to';  
  
  public function reviewSaveAfter(Varien_Event_Observer $observer) {               
    if(Mage::getStoreConfig('advancedreview/general/enabled_review')==1) {
      $dataobj =$observer->getEvent()->getData('data_object')->getData();
                           
      $productId  = $dataobj['entity_pk_value'];
      $resource = Mage::getSingleton('core/resource');
      $readConnection = $resource->getConnection('core_read');
      $table = $resource->getTableName('catalog_category_product');
      $query = 'SELECT category_id FROM ' . $table . ' WHERE product_id = '. (int)$productId . ' LIMIT 1';
      $categoryId = $readConnection->fetchOne($query);                 
      $customer = Mage::getSingleton('customer/session')->getCustomer();
      $mailcus = $customer->getEmail(); 
      $productUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'review/product/list/id/'.$productId.'category/'.$categoryId;                    
      //send mail to admin  
      $data = array('nickname'=>$dataobj['nickname'],'detail'=>$dataobj['detail'],'email'=>$mailcus,
      'createdate'=>$dataobj['created_at'],'listreviewurl'=>$productUrl) ; 
      //Zend_Debug::dump($data);die();     
      $postObject = new Varien_Object();
      $postObject->setData($data);        
      //die(print_r($postObject));   
      $translate = Mage::getSingleton('core/translate');
      $translate->setTranslateInline(false);                             
      $arraymail =  Mage::getStoreConfig(self::XML_PATH_SENT_TO) ;
      $arrmail = explode(",", $arraymail);
      foreach($arrmail as $row) 
      {
        $mailTemplate = Mage::getModel('core/email_template');  
        $mailTemplate->setDesignConfig(array('area' => 'frontend'))
        ->setReplyTo(Mage::getStoreConfig(self::XML_PATH_EMAIL_REPLY_TO))
        ->sendTransactional(
          Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
          Mage::getStoreConfig(self::XML_PATH_EMAIL_ADMIN_SENDER),
          $row,
          null,
          array('data' => $postObject) 
        );
        }
      $translate->setTranslateInline(true);                                           
      if($customer = Mage::getSingleton('customer/session')->isLoggedIn()) {
        try{
        $translate = Mage::getSingleton('core/translate');                         
        $translate->setTranslateInline(false);
        $email = Mage::getModel('core/email_template');
        $email->sendTransactional(
        Mage::getStoreConfig(self::XML_PATH_EMAIL_CUSTOMER_TEMPLATE),
        Mage::getStoreConfig(self::XML_PATH_EMAIL_ADMIN_SENDER),
        $mailcus,
        null,
        array('data'=>$postObject)
        );                       
        $translate->setTranslateInline(true);    
        }catch(Exception $e){
          
        }             
      }
    }     
  }
} 
?>
