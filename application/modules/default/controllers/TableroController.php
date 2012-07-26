<?php

class TableroController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->titulo = 'MODULOS';
        $this->view->resumen = 'Modulos activos de la Extranet de gestión de Creatividad e Inteligencia';
    }

    public function indexAction()
    {
    }
    public function cerrarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if(Zend_Auth::getInstance()->hasIdentity()){
            /* [CERRAR SESSION] */
            Zend_auth::getInstance()->clearIdentity();
        }       
        /* [REDIRECCIONAR] */
        $this->_redirect('/');             
    }
    public function perfilAction(){
        /* [TITLE] */
        $this->view->headTitle()->prepend('Mi perfil - ');         
    }


}

