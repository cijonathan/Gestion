<?php

class Mantenedor_ProyectoController extends Zend_Controller_Action
{

    protected $id_registro;
    
    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'PROYECTO';
        $this->view->resumen = 'Control de los proyecto de clientes para el Timesheet de Creatividad e Inteligencia';        
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
        $proyecto = new Mantenedor_Model_DbTable_Proyecto();
        $this->view->datos = $proyecto->listar();
    }
    public function agregarAction()
    {
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Proyecto();
        $this->view->formulario = $formulario;      
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                $proyecto = new Mantenedor_Model_DbTable_Proyecto();
                if($proyecto->guardar($datos)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/proyecto/');                
            }   
        }        
    }    
    public function editarAction(){
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Proyecto();
        $this->view->formulario = $formulario;
        /* new class */
        $proyecto = new Mantenedor_Model_DbTable_Proyecto();
        /* PROCESAR */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new class() */
                $mensaje = new Zend_Session_Namespace('mensaje');
                if($proyecto->actualizar($datos,$this->id_registro)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/proyecto/');                
            }   
        }else{
            $formulario->populate($proyecto->obtener($this->id_registro));
        }        
    }    
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $proyecto = new Mantenedor_Model_DbTable_Proyecto();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($proyecto->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/mantenedor/proyecto/');           
    }     
}

