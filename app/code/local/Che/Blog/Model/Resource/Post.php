<?php

class Che_Blog_Model_Resource_Post extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('blog/post','id_post');
    }
}