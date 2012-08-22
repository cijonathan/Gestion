<?php

class Usuario_Form_Usuario extends Zend_Form
{

    public function init()
    {
        $this->setName('usuario');
        $this->setAttrib('id','formulario');  
        $this->setAttrib('class', 'form-horizontal');        
        /* Limpiar docoradores por defecto */
        $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form');
        
        /* Añadir nuevos decoradores para Bootstrap Twitter */
        $decorator = array(
            'Errors',
            'ViewHelper',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class'=>'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) ),
        );
        /* Añadir decoradores para submit */
        $decorator_submit = array(
            'Errors',
            'ViewHelper',
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'form-actions' ) ),
        );        
                
        /* NOMBRE  */
        $nombre = new Zend_Form_Element_Text('nombre_usuario');
        $nombre->setRequired(true)
                ->setLabel('Nombre:')
                ->setDecorators($decorator)                
                ->setAttrib('class','required span4');        
        /* EMAIL  */
        $email = new Zend_Form_Element_Text('email_usuario');
        $email->setRequired(true)
                ->setLabel('Email:')
                ->setDecorators($decorator)                
                ->setAttrib('class','required email span4');        
        /* CLAVE */
        $clave = new Zend_Form_Element_Text('clave_usuario');
        $clave->setRequired(true)
                ->setLabel('Clave')
                ->setDecorators($decorator)                
                ->setAttrib('class','required span4');
        /* CARGO */
        $cargo = new Zend_Form_Element_Select('id_cargo');
        $cargo->setRequired(true)
                ->setAttrib('class','required span4')
                ->setDecorators($decorator)                
                ->setLabel('Cargo:');        
        $cargo_db = new Usuario_Model_DbTable_Cargo();
        $cargo->addMultiOption('','');        
        foreach($cargo_db->listar() as $retorno){
            $cargo->addMultiOption($retorno->id_cargo,$retorno->nombre_cargo);
        }        
        /* TIPO */
        $tipo = new Zend_Form_Element_Select('id_tipo');
        $tipo->setRequired(true)
                ->setAttrib('class','required span4')
                ->setDecorators($decorator)                
                ->setLabel('Tipo:');        
        $tipo_db = new Usuario_Model_DbTable_Tipo();
        $tipo->addMultiOption('','');        
        foreach($tipo_db->listar() as $retorno){
            $tipo->addMultiOption($retorno->id_tipo,ucfirst($retorno->nombre_tipo));
        }  
        /* AREA */
        $area = new Zend_Form_Element_Select('id_area');
        $area->setRequired(true)
                ->setAttrib('class','required span4')
                ->setDecorators($decorator)                
                ->setLabel('Área:');        
        $area_db = new Mantenedor_Model_DbTable_Area();
        $area->addMultiOption('','');        
        foreach($area_db->listar() as $retorno){
            $area->addMultiOption($retorno->id_area,ucfirst($retorno->nombre_area));
        }         
        /* SUB AREA */
        $subarea = new Zend_Form_Element_Select('id_subarea');
        $subarea->setRequired(true)
                ->setAttrib('class','required span4')
                ->setDecorators($decorator)                
                ->setLabel('Subarea:');        
        $subarea_db = new Mantenedor_Model_DbTable_Subarea();
        $subarea->addMultiOption(0,'');        
        foreach($subarea_db->listar() as $retorno){
            $subarea->addMultiOption($retorno->id_subarea,ucfirst($retorno->nombre_area.' - '.$retorno->nombre_subarea));
        }         
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('submit');
        $boton->setAttrib('class','btn btn-primary btn-large')
                ->setDecorators($decorator_submit)
              ->setLabel('GUARDAR');

        $this->addElements(array($nombre,$email,$clave,$cargo,$tipo,$area,$subarea,$boton));        
        
        /* Campo legend */
        $this->addDisplayGroup(
                array('nombre_usuario', 'email_usuario', 'clave_usuario'), 'birthday', array('legend' => 'Datos personales' )
        );
        $this->addDisplayGroup(
                array('id_cargo','id_tipo','id_area','id_subarea','submit'),'birthday1',array('legend'=>'Configuración del área')
        );
        $this->setDisplayGroupDecorators(array( 
            'FormElements', 
            'Fieldset', 
            // array('HtmlTag', array('class' => 'someclassname')) 
        ));        
    }


}

