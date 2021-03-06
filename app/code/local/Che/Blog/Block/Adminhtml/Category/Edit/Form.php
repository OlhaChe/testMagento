<?php


class Che_Blog_Block_Adminhtml_Category_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('category_request');
        $this->setTitle(Mage::helper('blog')->__('Request info'));
    }

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('category_request');

        $form = new Varien_Data_Form([
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', ['id' => $this->getRequest()->getParam('id_category')]),
            'method' => 'post',
            'enctype' => 'multipart/form-data'

            ]
        );


        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => Mage::helper('blog')->__('General Information'),
            'class' => 'fieldset-wide'
        ]);

        if ($model->getBlockId()) {
            $fieldset->addField('id_category', 'hidden', [
                'name' => 'id_category',
            ]);
        }

        $fieldset->addField('name', 'text', [
            'name'     => 'name',
            'label'    => Mage::helper('blog')->__('Category Name'),
            'title'    => Mage::helper('blog')->__('Category Name'),
            'required' => true,
        ]);

        $fieldset->addField('description', 'textarea', [
            'name'     => 'description',
            'label'    => Mage::helper('blog')->__('Description'),
            'title'    => Mage::helper('blog')->__('Description'),
            'required' => true,
        ]);
        $fieldset->addField('image', 'file', array(
            'label'     => Mage::helper('blog')->__('Image'),
            'required'  => false,
            'name'      => 'image',
        ));


        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}