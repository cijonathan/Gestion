<?php

class Mantenedor_AreaController extends Zend_Controller_Action
{

    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'ÁREA';
        $this->view->resumen = 'Control de las areas de trabajo de Creatividad e Inteligencia';        
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
        $area = new Mantenedor_Model_DbTable_Area();
        $this->view->datos = $area->listar();
    }
    public function agregarAction()
    {
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Area();
        $this->view->formulario = $formulario;      
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                $area = new Mantenedor_Model_DbTable_Area();
                if($area->guardar($datos)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/area/');                
            }   
        }        
    }  
    public function editarAction(){
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Area();
        $this->view->formulario = $formulario;
        /* new class */
        $area = new Mantenedor_Model_DbTable_Area();
        /* PROCESAR */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new class() */
                $mensaje = new Zend_Session_Namespace('mensaje');
                if($area->actualizar($datos,$this->id_registro)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/area/');                
            }   
        }else{
            $formulario->populate($area->obtener($this->id_registro));
        }        
    } 
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $area = new Mantenedor_Model_DbTable_Area();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($area->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/mantenedor/area/');           
    }  

}

