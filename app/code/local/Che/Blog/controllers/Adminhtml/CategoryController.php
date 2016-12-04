<?php

class Che_Blog_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {

        $this->_title($this->__('Category'))->_title($this->__('Category'));
        $this->loadLayout();
        $this->_setActiveMenu('cms/blog_category');
        $this->_addContent($this->getLayout()->createBlock('blog/adminhtml_category'));
        $this->renderLayout();

    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('blog/adminhtml_category_grid')->toHtml()
        );

    }
    public function newAction()
    {
        $this->_forward('edit');

    }
    public function editAction()
    {
        $this->_title($this->__('Category Request'));


        // 1. Get ID and create model
        $model = Mage::getModel('blog/category');
        // 2. Initial checking
        if ($id = $this->getRequest()->getParam('id_category')) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->
                addError(Mage::helper('blog')->
                __('This block no longer exists.'));

                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Category'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }
        // 4. Register model to use later in blocks
        Mage::register('category_request', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('blog/adminhtml_category_edit'));
        $this->_setActiveMenu('cms/blog_category')
//
            ->_addBreadcrumb($id ? Mage::helper('blog')->
            __('Edit category') : Mage::helper('blog')->
            __('New category'), $id ? Mage::helper('blog')->
            __('Edit category') : Mage::helper('blog')->
            __('New category'));

        $this->renderLayout();

    }
    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array
     * @return array
     */
    protected function _filterPostData($data)
    {
        $data = $this->_filterDates($data, array('custom_theme_from', 'custom_theme_to'));
        return $data;
    }
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            $data = $this->_filterPostData($data);
            //and (file_exists($_FILES['fileinputname']['tmp_name']))
            if(isset($_FILES['image']['name']) ) {
                try {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


                    $uploader->setAllowRenameFiles(false);

                    // setAllowRenameFiles(true) -> move your file in a folder the magento way
                    // setAllowRenameFiles(true) -> move your file directly in the $path folder
                    $uploader->setFilesDispersion(false);

                    $path = Mage::getBaseDir('media') . DS ;

                    $uploader->save($path, $_FILES['image']['name']);

                    $data['image'] = $_FILES['image']['name'];
                }catch(Exception $e) {

                }
            }else {

                if(isset($data['image']['delete']) && $data['image']['delete'] == 1)
                    $data['image_main'] = '';
                else
                    unset($data['image']);
            }
//            $data['update_at'] = date('Y-m-d H:i:s');

            //init model and set data
            $model = Mage::getModel('blog/category');

            if ($id = $this->getRequest()->getParam('id_category')) {
                $model->load($id);
            }

            $model->setData($data);

            Mage::dispatchEvent('cms_page_prepare_save', array('page' => $model, 'request' => $this->getRequest()));

            //validating
            if (!($data)) {
                $this->_redirect('*/*/edit', array('id_category' => $model->getId(), '_current' => true));
                return;
            }

            // try to save it
            try {
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('blog')->__('The category has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id_category' => $model->getId(), '_current'=>true));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('cms')->__('An error occurred while saving the page.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('id_category' => $this->getRequest()->getParam('id_category')));
            return;
        }

    }
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id_category')) {
            try {
                Mage::getModel('blog/category')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Category delete'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id_category' => $id));
            }
        }
        $this->_redirect('*/*/');

    }

}