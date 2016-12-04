<?php

class Che_Blog_Block_Adminhtml_Post extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'blog';
        $this->_controller = 'adminhtml_post';
        $this->_headerText = Mage::helper('blog')->__('Post');

        parent::__construct();
        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('blog')->__('Add New Post'));
        } else {
            $this->_removeButton('add');
        }
    }
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/post/' . $action);
    }
}