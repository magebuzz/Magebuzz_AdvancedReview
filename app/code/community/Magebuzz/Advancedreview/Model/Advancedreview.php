<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
class Magebuzz_Advancedreview_Model_Advancedreview extends Mage_Core_Model_Abstract {
  const XML_PATH_NUMBER_LATEST_REVIEW  = 'advancedreview/general/number_latest_review';
  public function _construct(){
    parent::_construct();
    $this->_init('advancedreview/advancedreview');
  } 
  public function toOptionArray() {   
    return array(
      array('value' => 'none', 'label'=>Mage::helper('adminhtml')->__('None')),
      array('value' => 'left', 'label'=>Mage::helper('adminhtml')->__('Left Sidebar')),
      array('value' => 'right', 'label'=>Mage::helper('adminhtml')->__('Right Sidebar'))
      );
  }
   public function getDataLatestReview() {
    $number = Mage::getStoreConfig(self::XML_PATH_NUMBER_LATEST_REVIEW);
    $collection = Mage::getModel('review/review')->getCollection()->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED);
    $collection->getSelect()->order(array('review_id DESC'));
    $collection->getSelect()->limit($number);
    return $collection;
  }  
}