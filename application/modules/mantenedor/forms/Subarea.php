<?php

class Mantenedor_Form_Subarea extends Zend_Form
{

    public function init()
    {
        $this->setName('area');
        $this->setAttrib('id','formulario');     
        /* NOMBRE REGION */
        $region = new Zend_Form_Element_Text('nombre_subarea');
        $region->setRequired(true)
                ->setLabel('Nombre Subarea:')
                ->setAttrib('class','required span4');
        /* AREA */
        $area = new Zend_Form_Element_Select('id_area');
        $area->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Área:');        
        $area_db = new Mantenedor_Model_DbTable_Area();
        $area->addMultiOption(0,'');          
        foreach($area_db->listar() as $retorno){
            $area->addMultiOption($retorno->id_area,$retorno->nombre_area);
        }
        unset($retorno,$area_db);           
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($region,$area,$boton));        
    }


}

