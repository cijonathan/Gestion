<?php

class Mantenedor_Form_Proyecto extends Zend_Form
{

    public function init()
    {
        $this->setName('rol');
        $this->setAttrib('id','formulario');     
        /* NOMBRE PROYECTO */
        $nombre = new Zend_Form_Element_Text('nombre_proyecto');
        $nombre->setRequired(true)
                ->setLabel('Nombre Proyecto:')
                ->setAttrib('class','required span4');
        /* CLIENTE */
        $cliente = new Zend_Form_Element_Select('id_cliente');
        $cliente->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Cliente:');        
        #$provincia_db = new Mantenedor_Model_DbTable_Provincia();
        $cliente_db = new Facturacion_Model_DbTable_Cliente();        
        $cliente->addMultiOption(0,'');          
        foreach($cliente_db->listar(1) as $retorno){
            $cliente->addMultiOption($retorno->id_cliente,$retorno->nombre_cliente);
        }
        unset($retorno,$cliente_db);           
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($nombre,$cliente,$boton));        
    }


}

