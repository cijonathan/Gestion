<?php

class Mantenedor_Form_Comuna extends Zend_Form
{

    public function init()
    {
        $this->setName('comuna');
        $this->setAttrib('id','formulario');     
        /* NOMBRE PROVINCIA */
        $comuna = new Zend_Form_Element_Text('nombre_comuna');
        $comuna->setRequired(true)
                ->setLabel('Nombre Comuna:')
                ->setAttrib('class','required span4');         
        /* PROVINCIA */
        $provincia = new Zend_Form_Element_Select('id_provincia');
        $provincia->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Provincia:');        
        $provincia_db = new Mantenedor_Model_DbTable_Provincia();
        $provincia->addMultiOption(0,'');          
        foreach($provincia_db->listar() as $retorno){
            $provincia->addMultiOption($retorno->id_provincia,$retorno->nombre_provincia);
        }
        unset($retorno,$provincia_db);        
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($comuna,$provincia,$boton));        
    }


}

