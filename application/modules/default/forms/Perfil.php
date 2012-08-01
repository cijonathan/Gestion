<?php

class Default_Form_Perfil extends Zend_Form
{

    public function init()
    {
        $this->setName('perfil');
        $this->setAttrib('id','formulario');            
        /* CLAVE */
        $clave = new Zend_Form_Element_Text('clave_usuario');
        $clave->setRequired(true)
                ->setLabel('Clave:')                
                ->setAttrib('class','required span4');         
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('ACTUALIZAR');

        $this->addElements(array($clave,$boton));        
    }



}

