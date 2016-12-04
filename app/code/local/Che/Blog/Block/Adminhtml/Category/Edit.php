<?php


class Che_Blog_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId   = 'id_category';
        $this->_blockGroup = 'blog';
        $this->_controller = 'adminhtml_category';
        $this->_mode = 'edit';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('blog')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('blog')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
                   function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
}