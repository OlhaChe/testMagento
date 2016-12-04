<?php

class Che_Blog_Model_Post extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('blog/post');
    }
}