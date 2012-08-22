<?php

class Mantenedor_ActividadController extends Zend_Controller_Action
{
    protected $id_registro;
    
    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'ACTIVIDAD';
        $this->view->resumen = 'Control de los actividad de usuarios para el Timesheet de Creatividad e Inteligencia';        
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
        $actividad = new Mantenedor_Model_DbTable_Actividad();
        $this->view->datos = $actividad->listar();
    }
    public function agregarAction()
    {
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Actividad();
        $this->view->formulario = $formulario;      
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                $actividad = new Mantenedor_Model_DbTable_Actividad();
                if($actividad->guardar($datos)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/actividad/');                
            }   
        }        
    }  
    public function editarAction(){
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Actividad();
        $this->view->formulario = $formulario;
        /* new class */
        $actividad = new Mantenedor_Model_DbTable_Actividad();
        /* PROCESAR */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new class() */
                $mensaje = new Zend_Session_Namespace('mensaje');
                if($actividad->actualizar($datos,$this->id_registro)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/actividad/');                
            }   
        }else{
            $formulario->populate($actividad->obtener($this->id_registro));
        }        
    } 
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $actividad = new Mantenedor_Model_DbTable_Actividad();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($actividad->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/mantenedor/actividad/');           
    } 


}

