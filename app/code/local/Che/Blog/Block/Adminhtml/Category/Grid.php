<?php

class Che_Blog_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('category_grid');
        $this->setDefaultSort('id_category');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('blog/category_collection');

        $this->setCollection($collection);
        parent::_prepareCollection();

        return $this;
    }
    protected function _prepareColumns()
    {
        $helper = Mage::helper('blog');

        $this->addColumn('id_category', [
            'header' => $helper->__('id_category'),
            'index'  => 'id_category',
        ]);

        $this->addColumn('name', [
            'header' => $helper->__('Name Category'),
            'type'   => 'text',
            'index'  => 'name',
        ]);
        $this->addColumn('description', [
            'header' => $helper->__('Description'),
            'type'   => 'text',
            'index'  => 'description',
        ]);


        return parent::_prepareColumns();
    }
    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['id_category' => $row->getId()]);
    }

    public function getGridUrl($params = [])
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

}