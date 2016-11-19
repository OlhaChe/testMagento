<?php

class Che_Techtalk_Adminhtml_ContactController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {

        $this->_title($this->__('Ain Contact'))->_title($this->__('Ain Contact'));
        $this->loadLayout();
        $this->_setActiveMenu('cms/ain_contact');
//        $this->_setActiveMenu('ain_contact');
        $this->_addContent($this->getLayout()->createBlock('techtalk/adminhtml_contact'));
        $this->renderLayout();

    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('techtalk/adminhtml_contact_grid')->toHtml()
        );

    }
    public function newAction()
    {
        $this->_forward('edit');

    }
    public function editAction()
    {
        $this->_title($this->__('Contact Request'));

        $model = Mage::getModel('techtalk/contact');

        if ($id = $this->getRequest()->getParam('request_id')) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->
                addError(Mage::helper('techtalk')->
                __('This block no longer exists.'));

                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Request'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }
        Mage::register('contact_request', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('techtalk/adminhtml_contact_edit'));
        $this->_setActiveMenu('cms/ain_contact')
//            $this->_setActiveMenu('ain_contact')
            ->_addBreadcrumb($id ? Mage::helper('techtalk')->
            __('Edit Request') : Mage::helper('techtalk')->
            __('New Request'), $id ? Mage::helper('techtalk')->
            __('Edit Request') : Mage::helper('techtalk')->
            __('New Request'))
                ->renderLayout();

    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('techtalk/contact')->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->
                addError(Mage::helper('cms')->
                __('This block no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            $model->setData($data);

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->
                addSuccess(Mage::helper('cms')->
                __('The block has been saved.'));

                Mage::getSingleton('adminhtml/session')->
                setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('request_id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                Mage::getSingleton('adminhtml/session')->setFormData($data);

                $this->_redirect('*/*/edit', array('request_id' => $this->getRequest()->getParam('request_id')));
                return;
            }
        }
        $this->_redirect('*/*/');

    }
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('request_id')) {
            try {
                Mage::getModel('techtalk/contact')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Block delete'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('request_id' => $id));
            }
        }
        $this->_redirect('*/*/');

    }
}