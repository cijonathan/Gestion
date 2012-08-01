<?php

class Mantenedor_TipoclienteController extends Zend_Controller_Action
{

public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'TIPO CLIENTE';
        $this->view->resumen = 'Control de los tipos de clientes de Creatividad e Inteligencia';        
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
        /* LISTAR */
        $tipo = new Mantenedor_Model_DbTable_Tipocliente();
        $this->view->datos = $tipo->listar();
    }
    public function agregarAction()
    {
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Tipocliente();
        $this->view->formulario = $formulario;      
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                $tipo = new Mantenedor_Model_DbTable_Tipocliente();
                if($tipo->guardar($datos)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/tipocliente/');                
            }   
        }        
    }  
    public function editarAction(){
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Tipocliente();
        $this->view->formulario = $formulario;
        /* new class */
        $tipo = new Mantenedor_Model_DbTable_Tipocliente();
        /* PROCESAR */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new class() */
                $mensaje = new Zend_Session_Namespace('mensaje');
                if($tipo->actualizar($datos,$this->id_registro)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/tipocliente/');                
            }   
        }else{
            $formulario->populate($tipo->obtener($this->id_registro));
        }        
    } 
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $tipo = new Mantenedor_Model_DbTable_Tipocliente();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($tipo->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/mantenedor/tipocliente/');           
    }  

}

