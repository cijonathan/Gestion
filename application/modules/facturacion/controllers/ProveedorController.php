<?php

class Facturacion_ProveedorController extends Zend_Controller_Action
{

    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'PROVEEDOR';
        $this->view->resumen = 'Control de los proveedor de Creatividad e Inteligencia';        
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
        $cliente = new Facturacion_Model_DbTable_Cliente();
        $this->view->datos = $cliente->listar(2);   
    }
    public function agregarAction()
    {
        /* FORMULARIO */
        $formulario = new Facturacion_Form_Cliente();
        $this->view->formulario = $formulario;      
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                $cliente = new Facturacion_Model_DbTable_Cliente();
                if($cliente->guardar($datos)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/facturacion/proveedor/');                
            }   
        }        
    } 
    public function editarAction(){
        /* FORMULARIO */
        $formulario = new Facturacion_Form_Cliente();
        $this->view->formulario = $formulario;      
        /* new class */
        $cliente = new Facturacion_Model_DbTable_Cliente();  
        /* PROCESAR */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                /* new class() */
                $mensaje = new Zend_Session_Namespace('mensaje');
                if($cliente->actualizar($datos,$this->id_registro)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/facturacion/proveedor/');                
            }   
        }else{
            $formulario->populate($cliente->obtener($this->id_registro));
        }         
    }    
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $cliente = new Facturacion_Model_DbTable_Cliente();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($cliente->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/facturacion/proveedor/');           
    }

}

