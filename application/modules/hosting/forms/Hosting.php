<?php

class Hosting_Form_Hosting extends Zend_Form
{

    public function init()
    {
        $this->setName('hosting');
        $this->setAttrib('id','formulario');        
        /* CLIENTE */
        $cliente = new Zend_Form_Element_Select('id_cliente');
        $cliente->setRequired(true)
                ->setAttrib('class','required span6')
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
                ->setLabel('Email:')
                ->setAttrib('class','required email span6');
        /* DOMINIO */
        $dominio = new Zend_Form_Element_Text('dominio_hosting');
        $dominio->setRequired(true)
                ->setLabel('Dominio (URL):')
                ->setAttrib('class','required url span6');        
        /* FECHA REGISTRO */
        $fecha = new Zend_Form_Element_Text('fecha_registro');
        $fecha->setRequired(true)
                ->setLabel('Fecha registro:')
                ->setValue(date('d-m-Y'))
                ->setAttrib('class','required datepicker span6');        
        /* PLAN */
        $plan = new Zend_Form_Element_Select('id_plan');
        $plan->setRequired(true)
                ->setAttrib('class','required span6')
                ->setLabel('Plan:');        
        $plan_db = new Hosting_Model_DbTable_Hostingplan();
        $plan->addMultiOption(0,'');        
        foreach($plan_db->listar() as $retorno){
            $plan->addMultiOption($retorno->id_plan,$retorno->nombre_plan);
        }
        /* ESTADO */
        $estado = new Zend_Form_Element_Select('id_estado');
        $estado->setRequired(true)
                ->setAttrib('class','required span6')
                ->setLabel('Estado:');        
        $estado_db = new Hosting_Model_DbTable_Hostingestado();
        $estado->addMultiOption(0,'');        
        foreach($estado_db->listar() as $retorno){
            $estado->addMultiOption($retorno->id_estado,$retorno->nombre_estado);
        }
        unset($retorno,$estado_db);        
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');

        $this->addElements(array($cliente,$email,$dominio,$fecha,$plan,$estado,$boton));
        
    }


}

