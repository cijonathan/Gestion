<?php

class Mantenedor_RolController extends Zend_Controller_Action
{

public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'ROL';
        $this->view->resumen = 'Control de los roles de usuarios de Creatividad e Inteligencia';        
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
        $tipo = new Mantenedor_Model_DbTable_Rol();
        $this->view->datos = $tipo->listar();
    }
    public function agregarAction()
    {
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Rol();
        $this->view->formulario = $formulario;      
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                $tipo = new Mantenedor_Model_DbTable_Rol();
                if($tipo->guardar($datos)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/rol/');                
            }   
        }        
    }  
    public function editarAction(){
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Rol();
        $this->view->formulario = $formulario;
        /* new class */
        $rol = new Mantenedor_Model_DbTable_Rol();
        /* PROCESAR */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new class() */
                $mensaje = new Zend_Session_Namespace('mensaje');
                if($rol->actualizar($datos,$this->id_registro)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/rol/');                
            }   
        }else{
            $formulario->populate($rol->obtener($this->id_registro));
        }        
    } 
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $rol = new Mantenedor_Model_DbTable_Rol();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($rol->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/mantenedor/rol/');           
    }  

}

