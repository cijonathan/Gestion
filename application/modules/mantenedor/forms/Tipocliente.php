<?php

class Mantenedor_Form_Tipocliente extends Zend_Form
{

    public function init()
    {
        $this->setName('tipocliente');
        $this->setAttrib('id','formulario');     
        /* NOMBRE REGION */
        $region = new Zend_Form_Element_Text('nombre_tipo');
        $region->setRequired(true)
                ->setLabel('Nombre Tipo Cliente:')
                ->setAttrib('class','required span4');         
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($region,$boton));        
    }


}

