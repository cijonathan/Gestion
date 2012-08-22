<?php
class Facturacion_Form_Factura extends Zend_Form{
    public function __construct($options = null){
        parent::__construct($options);
    }

    public function init(){
        $this->setName('factura');
        $this->setAttrib('id', 'form-factura');
        $this->setAttrib('class', 'form-horizontal');
        $this->setAttrib('action', "/facturacion/index/guardar-factura/");

        /* Limpiar docoradores por defecto */
        $this->clearDecorators()
            ->addDecorator('FormElements')
            // ->addDecorator('HtmlTag', array('tag' => 'fieldset'))
            ->addDecorator('Form');

        /* Añadir nuevos decoradores para Bootstrap Twitter */
        $decorator = array(
            'Errors',
            'ViewHelper',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class'=>'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) ),
        );

        /* Añadir decoradores para submit */
        $decorator_submit = array(
            'Errors',
            'ViewHelper',
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'form-actions' ) ),
        );

         /* Tipo de factura (Emitida/Recibida) */
        $tipo = $this->getAttrib('tipo');
        switch($tipo){
            case 1: $titulo_tipo = "Clientes"; break;
            case 2: $titulo_tipo = "Proveedores"; break;
            default:
            case 3: $titulo_tipo = "Clientes/Proveedores"; break;
        }
        $tipofactura = new Zend_Form_Element_Hidden("tipo"); 
        $tipofactura
            ->removeDecorator('Label')
            ->setValue($tipo);
        
        /* Folio */
        $folio = new Zend_Form_Element_Text('folio');
        $folio
            ->setLabel('Folio factura:')
            ->setRequired(true)
            ->setAttrib('placeholder', 'Ingresar número...')
            ->setAttrib('class', 'span4 required digits')
            ->setAttrib('maxlength', '100')
            ->setDecorators($decorator);
        
        /* Fecha emision */
        $fecha_emision = new Zend_Form_Element_Text('fecha_emision');
        $fecha_emision
            ->setLabel('Fecha emisión:')
            ->setAttrib('class', 'span2 required datepicker')
            ->setRequired(true)
            ->setDecorators($decorator);

        /* Fecha pago */
        $fecha_pago = new Zend_Form_Element_Text('fecha_pago');
        $fecha_pago
            ->setLabel('Fecha pago:')
            ->setAttrib('class', 'span2 required datepicker')
            ->setRequired(true)
            ->setDecorators($decorator);

        /* Valor neto */
        $valor = new Zend_Form_Element_Text('valor');
        $valor
            ->setLabel('Valor neto:')
            ->setAttrib('placeholder', 'Ingresar valor...')
            ->setAttrib('class', 'span2 required digits')
            ->setRequired(true)
            ->setDecorators($decorator);

        /* Cliente/proveedor */
        $cliente = new Facturacion_Model_DbTable_Cliente();
        $listado = $cliente->listar($tipo);
        
        $array = array(""=>"Seleccionar");
        foreach($listado as $item)
            $array[$item->id_cliente] = $item->nombre_cliente;
            
        $clientes = new Zend_Form_Element_Select('clientes');
        $clientes
            ->setLabel($titulo_tipo.':')
            ->setRequired(true)
            ->setDecorators($decorator)
            ->setMultiOptions($array)
            ->setAttrib('class', 'span8 required')
            ->setValue(array(""));

        /* Submit */
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setAttrib('class','btn btn-primary btn-large')
            ->setDecorators($decorator_submit)
            ->setLabel('Crear factura');

        /* Enviar elementos a la vista */
        $elementos = array($tipofactura,$folio,$fecha_emision,$fecha_pago,$clientes,$valor,$submit);
        $this->addElements($elementos);


        /* Campo legend */
        $this->addDisplayGroup(array('folio', 'fecha_emision', 'fecha_pago', 'clientes', 'valor', 'submit'), 'birthday', array( 
            'legend' => 'Completar formulario' 
        ));
        $this->setDisplayGroupDecorators(array( 
            'FormElements', 
            'Fieldset', 
            // array('HtmlTag', array('class' => 'someclassname')) 
        )); 

    }
}
?>