<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
  class Magebuzz_Advancedreview_Block_Helper extends Mage_Review_Block_Helper
{
    protected $_availableTemplates = array(
      'default' => 'advancedreview/helper/summary.phtml',
      'short'   => 'advancedreview/helper/summary_short.phtml'
    );  
    public function getReviewsUrl() {
      if(Mage::getStoreConfig('advancedreview/general/enabled_review') == 1) {
        return ;  
      }else {
      return Mage::getUrl('review/product/list', array(
      'id'        => $this->getProduct()->getId(),
      'category'  => $this->getProduct()->getCategoryId()
      ));
      }     
    }
}
  
?>
