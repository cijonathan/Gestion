<?php

class Timesheet_Form_Timesheet extends Zend_Form
{

    public function init()
    {
        $this->setName('timesheet');
        $this->setAttrib('id','login');   
        $this->setAttrib('class', 'form-inline sinmargen');
        /* FECHA */
        $fecha = new Zend_Form_Element_Text('registro_timesheet');
        $fecha->setLabel('Fecha:')
                ->setRequired(true)
                ->setAttrib('class', 'required datepicker input-small')
                ->setValue(date('d-m-Y'));        
        /* CLIENTE */
        $cliente = new Zend_Form_Element_Select('id_cliente');
        $cliente->setRequired(true)
                ->setAttrib('class','required span2')               
                ->setLabel('Cliente:');        
        $cliente_db = new Hosting_Model_DbTable_Cliente();
        $cliente->addMultiOption(null,'');          
        foreach($cliente_db->listarHosting() as $retorno){
            $cliente->addMultiOption($retorno->id_cliente,$retorno->nombre_cliente);
        }
        unset($retorno,$cliente_db);          
        /* PROYECTO */
        $proyecto = new Zend_Form_Element_Select('id_proyecto');
        $proyecto
                ->setRegisterInArrayValidator(false)               
                ->setAttrib('class','required span2')   
                ->setAttrib('disabled',true)
                ->setLabel('Proyecto:');        
        #$proyecto_db = new Mantenedor_Model_DbTable_Proyecto();
        #$proyecto->addMultiOption(0,'');          
        /*foreach($proyecto_db->listar() as $retorno){
            $proyecto->addMultiOption($retorno->id_proyecto,$retorno->nombre_proyecto);
        }
        unset($retorno,$cliente_db);        */
        /* ACTIVIDAD */
        $actividad = new Zend_Form_Element_Select('id_actividad');
        $actividad->setRequired(true)
                ->setAttrib('class','required span2')               
                ->setLabel('Actividad:');        
        $actividad_db = new Mantenedor_Model_DbTable_Actividad();
        $actividad->addMultiOption(null,'');          
        foreach($actividad_db->listar() as $retorno){
            $actividad->addMultiOption($retorno->id_actividad,$retorno->nombre_actividad);
        }
        unset($retorno,$actividad_db);        
        /* HORA */
        $hora = new Zend_Form_Element_Select('hora_timesheet');
        $hora->setRequired(true)
                ->setAttrib('class','required span1')               
                ->setLabel('Hora:');        
        $hora->addMultiOptions(array(
            null=>'',
            '0:30'=>'0:30',
            '1:00'=>'1:00',
            '1:30'=>'1:30',
            '2:00'=>'2:00',
            '2:30'=>'2:30',
            '3:00'=>'3:00',
            '3:30'=>'3:30',
            '4:00'=>'4:00',
            '4:30'=>'4:30',
            '5:00'=>'5:00',
            '5:30'=>'5:30',
            '6:00'=>'6:00',
            '6:30'=>'6:30',
            '7:00'=>'7:00',
            '7:30'=>'7:30',
            '8:00'=>'8:00',
            '8:30'=>'8:30',
            '9:00'=>'9:00',
        ));   
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('submit');
        $boton->setAttrib('class','btn btn-primary btn-small')                     
            ->removeDecorator('Label')        
              ->setLabel('GUARDAR');      
        $this->addElements(array($fecha,$cliente,$proyecto,$actividad,$hora,$boton));        
        /* decoradores */        
        $this->clearDecorators();
        $this->addDecorator('FormElements')
         ->addDecorator('HtmlTag', array('tag' => '<fieldset>'))
         ->addDecorator('Form');

        $this->setElementDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('Description'),
            array('Label', array('separator'=>' ')),
            array('HtmlTag', array('tag' => 'span'))
        ));         
    }


}

