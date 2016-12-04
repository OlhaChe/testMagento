<?php

class Che_Blog_Adminhtml_PostController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {

        $this->_title($this->__('Post'))->_title($this->__('Post'));
        $this->loadLayout();
        $this->_setActiveMenu('cms/blog_post');
        $this->_addContent($this->getLayout()->createBlock('blog/adminhtml_post'));
        $this->renderLayout();

    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('blog/adminhtml_post_grid')->toHtml()
        );

    }
    public function newAction()
    {
        $this->_forward('edit');

    }
    public function editAction()
    {
        $this->_title($this->__('Post Request'));


        // 1. Get ID and create model
        $model = Mage::getModel('blog/post');
        // 2. Initial checking
        if ($id = $this->getRequest()->getParam('id_post')) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->
                addError(Mage::helper('blog')->
                __('This block no longer exists.'));

                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Post'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }
        // 4. Register model to use later in blocks
        Mage::register('post_request', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('blog/adminhtml_post_edit'));
        $this->_setActiveMenu('cms/blog_post')
//
            ->_addBreadcrumb($id ? Mage::helper('blog')->
            __('Edit Post') : Mage::helper('blog')->
            __('New Post'), $id ? Mage::helper('blog')->
            __('Edit Post') : Mage::helper('blog')->
            __('New Post'));

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
            $data['update_at'] = date('Y-m-d H:i:s');
            $data = $this->_filterPostData($data);
            //init model and set data
            $model = Mage::getModel('blog/post');

            if ($id = $this->getRequest()->getParam('id_post')) {
                $model->load($id);
            }

            $model->setData($data);

            Mage::dispatchEvent('cms_page_prepare_save', array('page' => $model, 'request' => $this->getRequest()));

            //validating
            if (!($data)) {
                $this->_redirect('*/*/edit', array('id_post' => $model->getId(), '_current' => true));
                return;
            }

            // try to save it
            try {
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('blog')->__('The post has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id_post' => $model->getId(), '_current'=>true));
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
            $this->_redirect('*/*/edit', array('id_post' => $this->getRequest()->getParam('id_post')));
            return;
        }

    }
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id_post')) {
            try {
                Mage::getModel('blog/post')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Block delete'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id_post' => $id));
            }
        }
        $this->_redirect('*/*/');

    }

}