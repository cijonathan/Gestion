<?php

class Usuario_IndexController extends Zend_Controller_Action
{
    protected $id_registro;    

    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'USUARIO';
        $this->view->resumen = 'Control de usuarios del sistema de la EXTRANET';        
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
        $usuario = new Usuario_Model_DbTable_Usuario();
        $this->view->datos = $usuario->listar();
    }
    public function agregarAction(){
        /* FORMULARIO */
        $formulario = new Usuario_Form_Usuario();
        $this->view->formulario = $formulario;
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                $usuario = new Usuario_Model_DbTable_Usuario();
                if($usuario->guardar($datos)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/usuario/');                
            }   
        }
    }
    public function editarAction(){
        /* FORMULARIO */
        $formulario = new Usuario_Form_Usuario();
        $this->view->formulario = $formulario;
        /* new class */
        $usuario = new Usuario_Model_DbTable_Usuario();        
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new class() */
                $mensaje = new Zend_Session_Namespace('mensaje');
                if($usuario->actualizar($datos,$this->id_registro)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/usuario/');                
            }   
        }else{
            $formulario->populate($usuario->obtener($this->id_registro));
        }
    }
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $usuario = new Usuario_Model_DbTable_Usuario();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($usuario->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/usuario/');            
    }

}

