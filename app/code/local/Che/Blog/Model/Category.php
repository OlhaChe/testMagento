<?php

class Che_Blog_Model_Category extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('blog/category');
    }
    public function getCategories()
    {
        $catCollection = $this->getCollection();
        $catigories = array();
        foreach ($catCollection as $val)
        {
            $catigories[] = array('value' => $val->getId_category(), 'label' => $val->getName());
        }

       return $catigories;
    }

}