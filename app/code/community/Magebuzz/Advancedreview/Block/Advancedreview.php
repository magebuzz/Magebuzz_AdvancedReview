<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
class Magebuzz_Advancedreview_Block_Advancedreview extends Mage_Core_Block_Template
{
	public function _prepareLayout() { 
		return parent::_prepareLayout();
	}
  public function displayOnLeftSidebarBlock() {
    $block = $this->getParentBlock();
    if ($block) {
      if (Mage::getStoreConfig('advancedreview/general/display_latest_review')=='left') {					
        $sidebarBlock = $this->getLayout()->createBlock('advancedreview/sidebar');			
        $block->insert($sidebarBlock, '', true, 'advancedreview-category-sidebar');
      }
    }
  }
  public function displayOnRightSidebarBlock() {
    $block = $this->getParentBlock();
    if ($block) {
      if (Mage::getStoreConfig('advancedreview/general/display_latest_review')=='right') {
        $sidebarBlock = $this->getLayout()->createBlock('advancedreview/sidebar');
        $block->insert($sidebarBlock, '', true, 'advancedreview-category-sidebar');
      }
    }
  }     
}