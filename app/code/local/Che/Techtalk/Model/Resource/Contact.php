<?php

class Che_Techtalk_Model_Resource_Contact extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('techtalk/contact','request_id');
    }
}