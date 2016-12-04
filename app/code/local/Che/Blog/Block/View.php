<?php

//Mage_Page_Block_Html_Pager
//Mage_Core_Block_Template
class Che_Blog_Block_View extends Mage_Core_Block_Template
{
    public function getRequestPost($id)
    {
        return Mage::getModel('blog/post')->load($id);
    }
    public function getRequestCategory($id)
    {
        return Mage::getModel('blog/category')->load($id);
    }
    public function getPostCollection()
    {
        return Mage::getModel('blog/post')->getCollection()
            ->addFieldToFilter('status', 'enabled');
    }
    public function getCategoryCollection()
    {
        return Mage::getModel('blog/category')->getCollection();
    }
        public function getPostsCategory($category_id)
    {
        return Mage::getModel('blog/post')->getCollection()
            ->addFieldToFilter('cat_id', $category_id);
    }





}