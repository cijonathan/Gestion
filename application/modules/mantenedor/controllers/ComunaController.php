<?php

class Mantenedor_ComunaController extends Zend_Controller_Action
{

    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'COMUNA';
        $this->view->resumen = 'Control de las comunas del País de Chile';        
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
        $comuna = new Mantenedor_Model_DbTable_Comuna();
        $this->view->datos = $comuna->listar();
    }
    public function agregarAction()
    {
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Comuna();
        $this->view->formulario = $formulario;      
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                $comuna = new Mantenedor_Model_DbTable_Comuna();
                if($comuna->guardar($datos)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/comuna/');                
            }   
        }        
    }  
    public function editarAction(){
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Comuna();
        $this->view->formulario = $formulario;
        /* new class */
        $comuna = new Mantenedor_Model_DbTable_Comuna();
        /* PROCESAR */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new class() */
                $mensaje = new Zend_Session_Namespace('mensaje');
                if($comuna->actualizar($datos,$this->id_registro)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/comuna/');                
            }   
        }else{
            $formulario->populate($comuna->obtener($this->id_registro));
        }        
    } 
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $comuna = new Mantenedor_Model_DbTable_Comuna();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($comuna->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/mantenedor/comuna/');           
    }    

}

