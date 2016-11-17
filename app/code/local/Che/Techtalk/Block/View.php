<?php

class Che_Techtalk_Block_View extends Mage_Core_Block_Template
{
    public function getRequestRecord()
    {
        return Mage::getModel('techtalk/contact')->load(1);
    }
    public function getCollection()
    {
        return Mage::getModel('techtalk/contact')->getCollection();
    }

}