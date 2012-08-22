<?php

class Timesheet_AvisoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        /* [DESAHIBILITAR LAYOUT y VIEW] */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);     
        /* USUARIOS */
        $usuario = new Usuario_Model_DbTable_Usuario();
        $timesheet = new Timesheet_Model_DbTable_Timesheet();
        $email = new Timesheet_Model_Email();
        foreach($usuario->listar() as $retorno){            
            if($timesheet->avisoDiario($retorno->id)){
                $email->seispm($retorno->id);
            }
        }unset($retorno);
    }


}

