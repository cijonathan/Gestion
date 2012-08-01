<?php

class Hosting_IndexController extends Zend_Controller_Action
{
    protected $id_registro;

    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'HOSTING';
        $this->view->resumen = 'Control de clientes con cuenta de hosting en el VPS';        
        /* PARAMETROS */
        $this->id_registro = $this->_getParam('id',false);
    }

    public function indexAction()
    {
        /* [EXITO y ERROR] */
        $mensaje = new Zend_Session_Namespace('mensaje');
        $this->view->exito = $mensaje->exito;
        $this->view->error = $mensaje->error;
        $mensaje->setExpirationSeconds(1);
        unset($mensaje);  
        /* LISTADO */
        $hosting = new Hosting_Model_DbTable_Hosting();
        $this->view->datos = $hosting->listar();
    }
    public function agregarAction()
    {
        /* FORMULARIO */
        $formulario = new Hosting_Form_Hosting();
        $this->view->formulario = $formulario;
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new Class() */
                $hosting = new Hosting_Model_DbTable_Hosting();
                $mensaje = new Zend_Session_Namespace('mensaje');                
                if($hosting->guardar($datos)){
                    $mensaje->exito = true;
                }else{
                    $mensaje->error = true;                  
                }
                $this->_redirect('/hosting/');
            }
        }
    }
    public function editarAction(){
        /* FORMULARIO */
        $formulario = new Hosting_Form_Hosting();
        $this->view->formulario = $formulario;   
        /* new class */
        $hosting = new Hosting_Model_DbTable_Hosting();        
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();  
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                if($hosting->actualizar($datos,$this->id_registro)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                       
                }
                $this->_redirect('/hosting/');                
            }            
        }else{
            $datos = $hosting->obtener($this->id_registro);
            $formulario->populate($datos);
            unset($datos);
        }        
    }
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $hosting = new Hosting_Model_DbTable_Hosting();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($hosting->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/hosting/');        
    }
    public function renovarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */
        $mensaje = new Zend_Session_Namespace('mensaje');           
        $hosting = new Hosting_Model_DbTable_Hosting();
        if($hosting->renovar($this->id_registro)){
            $mensaje->exito = true;             
        }else{
            $mensaje->error = true;
        }
        $this->_redirect('/hosting/');        
    }
}

