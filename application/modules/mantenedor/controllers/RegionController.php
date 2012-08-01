<?php

class Mantenedor_RegionController extends Zend_Controller_Action
{
    protected $id_registro;

    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'REGIÓN';
        $this->view->resumen = 'Control de las regiones del País de Chile';        
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
        $region = new Mantenedor_Model_DbTable_Region();
        $this->view->datos = $region->listar();
    }
    public function agregarAction()
    {
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Region();
        $this->view->formulario = $formulario;      
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                $region = new Mantenedor_Model_DbTable_Region();
                if($region->guardar($datos)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/region/');                
            }   
        }        
    }
    public function editarAction(){
        /* FORMULARIO */
        $formulario = new Mantenedor_Form_Region();
        $this->view->formulario = $formulario;
        /* new class */
        $region = new Mantenedor_Model_DbTable_Region();
        /* PROCESAR */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new class() */
                $mensaje = new Zend_Session_Namespace('mensaje');
                if($region->actualizar($datos,$this->id_registro)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/mantenedor/region/');                
            }   
        }else{
            $formulario->populate($region->obtener($this->id_registro));
        }        
    }
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $region = new Mantenedor_Model_DbTable_Region();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($region->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/mantenedor/region/');           
    }

}

