<?php

class Che_Blog_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'blog';
        $this->_controller = 'adminhtml_category';
        $this->_headerText = Mage::helper('blog')->__('Category');

        parent::__construct();
        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('blog')->__('Add New Category'));
        } else {
            $this->_removeButton('add');
        }
    }
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/category/' . $action);
    }
    /**
     * Get button unique id
     *
     * @param string $suffix
     * @return string
     */
    public function getElementId($suffix)
    {
        return $this->getHtmlId() . '-' . $suffix;
    }
    public function getHtmlId()
    {
        return $this->getId();
    }
    /**
     * Add mapping ids for front-end use
     *
     * @param array $additionalButtons
     * @return $this
     */
    protected function _addElementIdsMapping($additionalButtons = array())
    {
        $this->_idsMapping = array_merge($this->_idsMapping, $additionalButtons);

        return $this;
    }
    /**
     * Prepare actual elements ids from suffixes
     *
     * @param array $targets $type => array($idsSuffixes)
     * @return array $type => array($htmlIds)
     */
    protected function _prepareElementsIds($targets)
    {
        return array_map(array($this, 'getElementId'), array_unique(array_values($targets)));
    }

    protected function _prepareLayout()
    {
        $this->setChild(
            'browse_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->addData(array(
                    // Workaround for IE9
                    'before_html' => sprintf(
                        '<div style="display:inline-block;" id="%s">',
                        $this->getElementId('browse')
                    ),
                    'after_html' => '</div>',
                    'id' => $this->getElementId('browse' . '_button'),
                    'label' => Mage::helper('uploader')->__('Browse Files...'),
                    'type' => 'button',
                ))
        );

        $this->setChild(
            'delete_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->addData(array(
                    'id' => '{{id}}',
                    'class' => 'delete',
                    'type' => 'button',
                    'label' => Mage::helper('uploader')->__('Remove')
                ))
        );

        $this->_addElementIdsMapping(array(
            'container' => $this->getHtmlId(),
            'templateFile' => $this->getElementId('template'),
            'browse' => $this->_prepareElementsIds(array('browse'))
        ));

        return parent::_prepareLayout();
    }

}