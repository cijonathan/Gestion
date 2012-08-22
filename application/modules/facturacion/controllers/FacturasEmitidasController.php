<?php
class Facturacion_FacturasEmitidasController extends Zend_Controller_Action{
    protected $id_registro;

    public function init(){}

    public function indexAction(){
         /* TITLE SECCIONES */
        $this->view->titulo = 'FACTURAS EMITIDAS';
        $this->view->resumen = '...';

        /* Libs */
        $this->view->headScript()
            ->appendFile('/js/jquery.dataTables.min.js') 
            ->appendFile('/js/jquery.dataTables.config.js');
    }

    /* Nueva factura */
    public function nuevaFacturaAction(){
         /* TITLE SECCIONES */
        $this->view->titulo = 'NUEVA FACTURA';
        $this->view->resumen = '...';

        $this->view->formulario = $formulario = new Facturacion_Form_Factura(array("tipo"=>3));
    }

    /* Editar factura */
    public function editarFacturaAction(){
         /* TITLE SECCIONES */
        $this->view->titulo = 'EDITAR FACTURA <small>Folio N° 1234</small>';
        $this->view->resumen = '...';

        $this->view->formulario = $formulario = new Facturacion_Form_Factura(array("tipo"=>3));
    }
}
?>
