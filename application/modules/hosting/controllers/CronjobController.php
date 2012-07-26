<?php

class Hosting_CronjobController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        /* DISABLE LAYOUT */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);        
        /* HOSTING */
        $hosting = new Hosting_Model_DbTable_Hosting();
        $hosting->cronjob();
    }


}

