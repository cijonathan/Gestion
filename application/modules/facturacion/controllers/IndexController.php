<?php

class Facturacion_IndexController extends Zend_Controller_Action
{
    protected $id_registro;

    public function init()
    {
        /* TITLE SECCIONES */
        $this->view->titulo = 'FACTURACIÓN';
        $this->view->resumen = 'Control de las facturas de los trabajos de Creatividad e Inteligencia';        
        /* PARAMETROS */
        $this->id_registro = $this->_getParam('id',false);
    }

    public function indexAction()
    {
        // action body
    }


}

