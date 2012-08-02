<?php

class LayoutController extends Zend_Controller_Action
{

    protected $sesion;

    public function init()
    {
        /* Initialize action controller here */
    }
    public function preDispatch() {
        #$this->sesion = new Zend_Session_Namespace('login');
    }
    public function topAction(){
        $registro = new Zend_Registry();
        $this->view->nombre_usuario = $registro->get('nombre_usuario');
    }
    public function footerAction(){}
}

