<?php

class Mantenedor_Form_Area extends Zend_Form
{

    public function init()
    {
        $this->setName('area');
        $this->setAttrib('id','formulario');     
        /* NOMBRE REGION */
        $region = new Zend_Form_Element_Text('nombre_area');
        $region->setRequired(true)
                ->setLabel('Nombre Área:')
                ->setAttrib('class','required span4');         
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($region,$boton));        
    }


}

