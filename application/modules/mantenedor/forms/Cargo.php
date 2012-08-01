<?php

class Mantenedor_Form_Cargo extends Zend_Form
{

    public function init()
    {
        $this->setName('cargo');
        $this->setAttrib('id','formulario');     
        /* NOMBRE REGION */
        $nombre = new Zend_Form_Element_Text('nombre_cargo');
        $nombre->setRequired(true)
                ->setLabel('Nombre Cargo:')
                ->setAttrib('class','required span4');         
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($nombre,$boton));        
    }


}

