<?php

class Facturacion_ClienteController extends Zend_Controller_Action
{
    protected $id_registro;

    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'CLIENTES';
        $this->view->resumen = 'Control de los clientes de Creatividad e Inteligencia';        
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
        $this->view->datos = $cliente->listar();        
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
                $this->_redirect('/facturacion/cliente/');                
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
                $this->_redirect('/facturacion/cliente/');                
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
        $this->_redirect('/facturacion/cliente/');           
    }  
    public function relacionAction(){
        /* [EXITO y ERROR] */
        $mensaje = new Zend_Session_Namespace('mensaje');
        $this->view->exito = $mensaje->exito;
        $this->view->error = $mensaje->error;
        $mensaje->setExpirationSeconds(1);
        unset($mensaje);        
        /* new class */
        $asignacion = new Facturacion_Model_DbTable_Cliente();
        /* LISTAR DATOS */        
        $this->view->datos = $asignacion->listarRelacion($this->id_registro);
        /* OBTENER DATOS CLIENTE */
        $this->view->cliente = (object)$asignacion->obtener($this->id_registro);
        /* FORMULARIO */
        $formulario = new Facturacion_Form_Clienterelacion();
        $this->view->formulario = $formulario;        
        /* PROCESAR */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){ 
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                $datos['id_cliente'] = $this->id_registro;
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                if($asignacion->guadarRelacion($datos)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/facturacion/cliente/relacion/id/'.$this->id_registro);                 
                
            }   
        }
        
    }
    public function eliminarelacionAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $asignacion = new Facturacion_Model_DbTable_Cliente();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($id = $asignacion->eliminaRelacion($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/facturacion/cliente/relacion/id/'.$id);          
        
    }
}

