<?php

class Mantenedor_Form_Rol extends Zend_Form
{

    public function init()
    {
        $this->setName('rol');
        $this->setAttrib('id','formulario');     
        /* NOMBRE ROL */
        $nombre = new Zend_Form_Element_Text('nombre_rol');
        $nombre->setRequired(true)
                ->setLabel('Nombre Rol:')
                ->setAttrib('class','required span4');         
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($nombre,$boton));        
    }


}

