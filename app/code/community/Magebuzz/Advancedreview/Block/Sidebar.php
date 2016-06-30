<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
class Magebuzz_Advancedreview_Block_Sidebar extends Mage_Core_Block_Template {
  public function _construct() {
    $this->setTemplate('advancedreview/sidebar.phtml');
    return parent::_construct();
  }
}