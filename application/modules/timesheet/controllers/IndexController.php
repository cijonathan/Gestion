<?php

class Timesheet_IndexController extends Zend_Controller_Action
{
    protected $id_registro;
    protected $id_usuario;
    
    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'TIMESHEET';
        $this->view->resumen = 'Control de los horas de trabajo de usuarios de Creatividad e Inteligencia';        
        /* PARAMETROS */
        $this->id_registro = $this->_getParam('id',false);
        $registro = new Zend_Registry();
        $this->id_usuario = $registro->get('id_usuario');
    }

    public function indexAction()
    {
        /* [EXITO y ERROR] */
        $mensaje = new Zend_Session_Namespace('mensaje');
        $this->view->exito = $mensaje->exito;
        $this->view->error = $mensaje->error;
        $mensaje->setExpirationSeconds(1);
        unset($mensaje);        
        $timesheet = new Timesheet_Model_DbTable_Timesheet();
        /* FECHA HOY */
        $fecha = new Zend_Date(date('d-m-Y'),'dd-MM-YYYY');
        $this->view->hoy = ucfirst($fecha->toString('EEEE dd MMMM YYYY'));
        /* HORAS TRABAJADAS */
        $this->view->horas = ($timesheet->HoraHoy($this->id_usuario)->total)? $timesheet->HoraHoy($this->id_usuario)->total : 0;
        /* LISTAR */
        $this->view->datos = $timesheet->listar($this->id_usuario);
        $this->view->otros = $timesheet->listarOtros($this->id_usuario);
        /* FORMULARIO */
        $formulario = new Timesheet_Form_Timesheet();
        $this->view->formulario = $formulario;
        /* [PROCESAR FORMULARIO] */
        $respuesta = $this->getRequest();
        if($respuesta->isPost()){   
            if($formulario->isValid($this->_request->getPost())){
                $datos = $formulario->getValues();
                $fecha = new Zend_Date($datos['registro_timesheet'],'d-m-Y');
                $data = array(
                    'registro_timesheet'=>$fecha->toString('Y-m-d'),
                    'id_proyecto'=>$datos['id_proyecto'],
                    'id_actividad'=>$datos['id_actividad'],
                    'hora_timesheet'=>$datos['hora_timesheet'],
                    'id_usuario'=>$this->id_usuario
                );
                /* new Class() */
                $mensaje = new Zend_Session_Namespace('mensaje');                 
                if($timesheet->guardar($data)){
                    $mensaje->exito = true;                    
                }else{
                    $mensaje->error = true;                     
                }
                $this->_redirect('/timesheet/');                
            }   
        }         
        
    }
    public function eliminarAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* PROCESAR */      
        $timesheet = new Timesheet_Model_DbTable_Timesheet();
        $mensaje = new Zend_Session_Namespace('mensaje');           
        if($timesheet->eliminar($this->id_registro)){
            $mensaje->exito = true;            
        }else{ 
            $mensaje->error = true;             
        }
        $this->_redirect('/timesheet/');          
    }
    public function obtenerAction(){
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        /* OBTENER */
        $proyecto = new Mantenedor_Model_DbTable_Proyecto();
        $json = new Zend_Json();
        echo $json->encode($proyecto->obtenerProyectos($this->id_registro));
    }

}

