<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
require_once("Mage/Review/controllers/ProductController.php");
  class Magebuzz_Advancedreview_ReviewController extends Mage_Review_ProductController
{        
  public function postAction() {  
    if(Mage::getStoreConfig('advancedreview/general/enabled_review')==1) {
      if($this->getRequest()->isPost()) {                    
        if(Mage::getStoreConfig('advancedreview/general/enabled_captcha')==1) {
          require_once('recaptchalib.php');
          $privatekey = "6LcHM98SAAAAACZZykPGiHU6ikXOLwdVVc7tPqM0";
          $resp = recaptcha_check_answer ($privatekey,
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]);
          if (!$resp->is_valid) {
          Mage::getSingleton('core/session')->addError(Mage::helper('advancedreview')->__("The CAPTCHA wasn't entered correctly. Go back and try it again."));
          Mage::app()->getResponse()->setRedirect($_SERVER['HTTP_REFERER']);            
          }else {
          parent::postAction();     
          }
        }else {
          parent::postAction();      
        }
      }
    }else{
      parent::postAction();      
    }
  }        
}
?>
