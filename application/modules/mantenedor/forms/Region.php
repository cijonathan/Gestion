<?php

class Mantenedor_Form_Region extends Zend_Form
{

    public function init()
    {
        $this->setName('region');
        $this->setAttrib('id','formulario');     
        /* NOMBRE REGION */
        $region = new Zend_Form_Element_Text('nombre_region');
        $region->setRequired(true)
                ->setLabel('Nombre Región:')
                ->setAttrib('class','required span4');         
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($region,$boton));        
    }


}

