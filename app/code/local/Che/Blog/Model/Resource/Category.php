<?php

class Che_Blog_Model_Resource_Category extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('blog/category','id_category');
    }
}