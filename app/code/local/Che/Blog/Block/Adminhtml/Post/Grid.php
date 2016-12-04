<?php

class Che_Blog_Block_Adminhtml_Post_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('post_grid');
        $this->setDefaultSort('id_post');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('blog/post_collection');

        $this->setCollection($collection);
        parent::_prepareCollection();

        return $this;
    }
    protected function _prepareColumns()
    {
        $helper = Mage::helper('blog');

        $this->addColumn('id_post', [
            'header' => $helper->__('id_post'),
            'index'  => 'id_post',
        ]);

        $this->addColumn('title', [
            'header' => $helper->__('Name Post'),
            'type'   => 'text',
            'index'  => 'title',
        ]);
        $this->addColumn('short_description', [
            'header' => $helper->__('Short description'),
            'type'   => 'text',
            'index'  => 'short_description',
        ]);
        $this->addColumn('update_at', [
            'header' => $helper->__('Update at'),
            'type'   => 'text',
            'index'  => 'update_at',
        ]);
        $this->addColumn('status', [
            'header' => $helper->__('Status'),
            'type'   => 'text',
            'index'  => 'status',
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
        return $this->getUrl('*/*/edit', ['id_post' => $row->getId()]);
    }

    public function getGridUrl($params = [])
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

}