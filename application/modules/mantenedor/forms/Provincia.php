<?php

class Mantenedor_Form_Provincia extends Zend_Form
{

    public function init()
    {
        $this->setName('region');
        $this->setAttrib('id','formulario');     
        /* NOMBRE PROVINCIA */
        $provincia = new Zend_Form_Element_Text('nombre_provincia');
        $provincia->setRequired(true)
                ->setLabel('Nombre Provincia:')
                ->setAttrib('class','required span4');         
        /* REGION */
        $region = new Zend_Form_Element_Select('id_region');
        $region->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Región:');        
        $region_db = new Mantenedor_Model_DbTable_Region();
        $region->addMultiOption(0,'');          
        foreach($region_db->listar() as $retorno){
            $region->addMultiOption($retorno->id_region,$retorno->nombre_region);
        }
        unset($retorno,$region_db);        
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($provincia,$region,$boton));        
    }


}

