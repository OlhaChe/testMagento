<?php

class Che_Blog_CategoryController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();

    }
//    public function postAction()
//    {
//        $pageId = $this->getRequest()
//            ->getParam('post_id', $this->getRequest()->getParam('id', false));
//    }
}