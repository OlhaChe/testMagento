<?php


class Che_Blog_Block_Adminhtml_Post_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('post_request');
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
        $model = Mage::registry('post_request');


        $form = new Varien_Data_Form(
            ['id' => 'edit_form', 'action' => $this->getUrl('*/*/save', ['id' => $this->getRequest()->getParam('id_post')]), 'method' => 'post']
        );


        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => Mage::helper('blog')->__('General Information'),
            'class' => 'fieldset-wide'
        ]);

        if ($model->getBlockId()) {
            $fieldset->addField('id_post', 'hidden', [
                'name' => 'id_post',

            ]);
        }

        $fieldset->addField('title', 'text', [
            'name'     => 'title',
            'label'    => Mage::helper('blog')->__('Post Name'),
            'title'    => Mage::helper('blog')->__('Post Name'),
            'required' => true,
        ]);

        $fieldset->addField('status', 'select', [
            'name'     => 'status',
            'label'    => Mage::helper('blog')->__('Status'),
            'title'    => Mage::helper('blog')->__('Status'),
            'values' => [
                1 => 'enabled',
                0 => 'disabled',
            ],
            'required' => true,
        ]);

        $fieldset->addField('cat_id', 'select', array(
            'name' => 'cat_id',
            'label' => Mage::helper('blog')->__('Сategory'),
            'title'    => Mage::helper('blog')->__('Category'),
            'class' => 'widget-option',
            'values' => Mage::getModel('blog/category')->getCategories()
        ));

        $fieldset->addField('short_description', 'textarea', [
            'name'     => 'short_description',
            'label'    => Mage::helper('blog')->__('Short description'),
            'title'    => Mage::helper('blog')->__('Short description'),
            'required' => true,
        ]);

        $fieldset->addField('content', 'editor', [
            'name'     => 'content',
            'label'    => Mage::helper('blog')->__('Content'),
            'title'    => Mage::helper('blog')->__('Content'),
            'style'    => 'height:36em',
            'required' => true,
            'config'   => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
        ]);
        //$postData = $this->_filterDates($postData, array("date"));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}