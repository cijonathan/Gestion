<?php

class Hosting_Form_Hosting extends Zend_Form
{

    public function init()
    {
        $this->setName('hosting');
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
                      
        /* CLIENTE */
        $cliente = new Zend_Form_Element_Select('id_cliente');
        $cliente->setRequired(true)
                ->setAttrib('class','required span4')
                ->setDecorators($decorator)                     
                ->setLabel('Cliente:');        
        $cliente_db = new Hosting_Model_DbTable_Cliente();
        $cliente->addMultiOption(0,'');          
        foreach($cliente_db->listarHosting() as $retorno){
            $cliente->addMultiOption($retorno->id_cliente,$retorno->nombre_cliente);
        }
        unset($retorno,$cliente_db);
        /* EMAIL NOTIFICACION  */
        $email = new Zend_Form_Element_Text('hosting_email_alternativo');
        $email->setRequired(true)
                ->setDecorators($decorator)                     
                ->setLabel('Email:')
                ->setAttrib('class','required email span4');
        /* DOMINIO */
        $dominio = new Zend_Form_Element_Text('dominio_hosting');
        $dominio->setRequired(true)
                ->setDecorators($decorator)                     
                ->setLabel('Dominio (URL):')
                ->setAttrib('class','required url span4');        
        /* FECHA REGISTRO */
        $fecha = new Zend_Form_Element_Text('fecha_registro');
        $fecha->setRequired(true)
                ->setDecorators($decorator)                     
                ->setLabel('Fecha registro:')
                ->setValue(date('d-m-Y'))
                ->setAttrib('class','required datepicker span4');        
        /* PLAN */
        $plan = new Zend_Form_Element_Select('id_plan');
        $plan->setRequired(true)
                ->setDecorators($decorator)                     
                ->setAttrib('class','required span4')
                ->setLabel('Plan:');        
        $plan_db = new Hosting_Model_DbTable_Hostingplan();
        $plan->addMultiOption(0,'');        
        foreach($plan_db->listar() as $retorno){
            $plan->addMultiOption($retorno->id_plan,$retorno->nombre_plan);
        }
        /* ESTADO */
        $estado = new Zend_Form_Element_Select('id_estado');
        $estado->setRequired(true)
                ->setDecorators($decorator)                     
                ->setAttrib('class','required span4')
                ->setLabel('Estado:');        
        $estado_db = new Hosting_Model_DbTable_Hostingestado();
        $estado->addMultiOption(0,'');        
        foreach($estado_db->listar() as $retorno){
            $estado->addMultiOption($retorno->id_estado,$retorno->nombre_estado);
        }
        unset($retorno,$estado_db);        
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('submit');
        $boton->setAttrib('class','btn btn-primary btn-large')
                ->setDecorators($decorator_submit)                     
              ->setLabel('GUARDAR');

        $this->addElements(array($cliente,$email,$dominio,$fecha,$plan,$estado,$boton));
        
        /* Campo legend */
        $this->addDisplayGroup(
                array('id_cliente', 'hosting_email_alternativo', 'dominio_hosting','fecha_registro','id_plan','id_estado','submit'), 'birthday', array('legend' => 'Completar el Formulario' )
        );
        $this->setDisplayGroupDecorators(array( 
            'FormElements', 
            'Fieldset', 
            // array('HtmlTag', array('class' => 'someclassname')) 
        ));           
        
    }


}

