<?php

class Usuario_Form_Usuario extends Zend_Form
{

    public function init()
    {
        $this->setName('usuario');
        $this->setAttrib('id','formulario');  
        /* NOMBRE  */
        $nombre = new Zend_Form_Element_Text('nombre_usuario');
        $nombre->setRequired(true)
                ->setLabel('Nombre:')
                ->setAttrib('class','required span4');        
        /* EMAIL  */
        $email = new Zend_Form_Element_Text('email_usuario');
        $email->setRequired(true)
                ->setLabel('Email:')
                ->setAttrib('class','required email span4');        
        /* CLAVE */
        $clave = new Zend_Form_Element_Text('clave_usuario');
        $clave->setRequired(true)
                ->setLabel('Clave')
                ->setAttrib('class','required span4');
        /* CARGO */
        $cargo = new Zend_Form_Element_Select('id_cargo');
        $cargo->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Cargo:');        
        $cargo_db = new Usuario_Model_DbTable_Cargo();
        $cargo->addMultiOption(0,'');        
        foreach($cargo_db->listar() as $retorno){
            $cargo->addMultiOption($retorno->id_cargo,$retorno->nombre_cargo);
        }        
        /* TIPO */
        $tipo = new Zend_Form_Element_Select('id_tipo');
        $tipo->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Tipo:');        
        $tipo_db = new Usuario_Model_DbTable_Tipo();
        $tipo->addMultiOption(0,'');        
        foreach($tipo_db->listar() as $retorno){
            $tipo->addMultiOption($retorno->id_tipo,ucfirst($retorno->nombre_tipo));
        }  
        /* AREA */
        $area = new Zend_Form_Element_Select('id_area');
        $area->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Área:');        
        $area_db = new Mantenedor_Model_DbTable_Area();
        $area->addMultiOption(0,'');        
        foreach($area_db->listar() as $retorno){
            $area->addMultiOption($retorno->id_area,ucfirst($retorno->nombre_area));
        }         
        /* SUB AREA */
        $subarea = new Zend_Form_Element_Select('id_subarea');
        $subarea->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Subarea:');        
        $subarea_db = new Mantenedor_Model_DbTable_Subarea();
        $subarea->addMultiOption(0,'');        
        foreach($subarea_db->listar() as $retorno){
            $subarea->addMultiOption($retorno->id_subarea,ucfirst($retorno->nombre_area.' - '.$retorno->nombre_subarea));
        }         
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($nombre,$email,$clave,$cargo,$tipo,$area,$subarea,$boton));        
    }


}

