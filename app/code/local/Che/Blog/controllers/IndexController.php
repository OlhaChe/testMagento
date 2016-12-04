<?php

class Che_Blog_IndexController extends Mage_Core_Controller_Front_Action
 {
      public function indexAction()
     {
         $this->loadLayout();
         $this->renderLayout();

     }
     public function postAction()
     {
         if(isset($_GET['id'])){
             $this->loadLayout();
             $this->renderLayout();
         }


     }
 }