<?php

class Brief_Form_Brief extends Zend_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);
	}

	public function init()
	{
		$id_usuario = $this->getAttrib('id_usuario');//se recupera el id del usuario actual		

		$this->setName('brief');
        $this->setAttrib('id', 'formulario');     
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
                      
        
        /* ID TEMPORAL DEL BRIEF */
        $id_temporal = new Zend_Form_Element_Hidden('id_temporal');
        $id_temporal->setAttrib('id', 'id_temporal')  ;                  
        $this->addElements(array($id_temporal));       

        /* SELECT DE CLIENTES */
        $cliente_brief = new Zend_Form_Element_Select('id_cliente');
        $cliente_brief->setRequired(true)
                      ->setAttrib('id', 'id_cliente')
                ->setDecorators($decorator)                   
                	  ->setAttrib('class','required')
                	  ->setLabel('Cliente:');        
        $cliente_db = new Brief_Model_DbTable_Cliente();
        $cliente_brief->addMultiOption('','Seleccione...');          
        foreach($cliente_db->listar_por_usuario($id_usuario) as $retorno){
            $cliente_brief->addMultiOption($retorno->id_cliente, $retorno->nombre_cliente);
        }
        unset($retorno, $cliente_db);  
        $this->addElements(array($cliente_brief));

        /* TITULO DEL BRIEF */
        $titulo_brief = new Zend_Form_Element_Text('nombre_proyecto_brief');
        $titulo_brief->setRequired(true)
                	 ->setLabel('Título Brief:')
                ->setDecorators($decorator)                   
                     ->setAttrib('id', 'nombre_proyecto_brief')
                	 ->setAttrib('class','required')    
                	 ->setAttrib('maxlength', '255');  
        $this->addElements(array($titulo_brief));  

        /* FECHA SOLICITUD */
        $fecha_solicitud = new Zend_Form_Element_Text('fecha_solicitud');
        $fecha_solicitud->setLabel('Fecha Solicitud:')
                        ->setAttrib('id', 'fecha_solicitud')
                ->setDecorators($decorator)                   
        				->setAttrib('readonly','readonly')
        				->setValue(date('d-m-Y'));
        $this->addElements(array($fecha_solicitud));  

        /* HORA SOLICITUD */
        $hora_solicitud = new Zend_Form_Element_Hidden('hora_solicitud');
        $hora_solicitud->setValue(date('H:i'))
                ->setDecorators($decorator)                   
                       ->setAttrib('id', 'hora_solicitud');
        $this->addElements(array($hora_solicitud));  

        /* FECHA REVISOR */
        $fecha_revisor = new Zend_Form_Element_Text('fecha_revisor');
        $fecha_revisor->setLabel('Fecha Revisor:')
                      ->setAttrib('id', 'fecha_revisor')
                ->setDecorators($decorator)                   
        			  ->setRequired(true)
        			  ->setAttrib('class', 'required datepicker_valida')
                      ->setValue(date('d-m-Y'));
        $this->addElements(array($fecha_revisor));  

        /* HORA REVISOR */
        $hora_revisor = new Zend_Form_Element_Text('hora_revisor');
        $hora_revisor->setLabel('Hora Revisor:') 
                     ->setAttrib('id', 'hora_revisor') 
                ->setDecorators($decorator)                   
        			 ->setRequired(true)
        			 ->setAttrib('class', 'timepicker-default'); 
        $this->addElements(array($hora_revisor));     

        /* FECHA PRESENTACION */
        $fecha_presentacion = new Zend_Form_Element_Text('fecha_presentacion');
        $fecha_presentacion->setLabel('Fecha Presentación:')
                           ->setAttrib('id', 'fecha_presentacion')
                ->setDecorators($decorator)                   
        				   ->setRequired(true)
        				   ->setAttrib('class', 'required datepicker_valida')
                           ->setValue(date('d-m-Y'));
        $this->addElements(array($fecha_presentacion));  

        /* HORA PRESENTACIÓN */
        $hora_presentacion = new Zend_Form_Element_Text('hora_presentacion');
        $hora_presentacion->setLabel('Hora Presentación:')  
                          ->setAttrib('id', 'hora_presentacion')
                ->setDecorators($decorator)                   
        			 	  ->setRequired(true)
        			 	  ->setAttrib('class', 'timepicker-default'); 
        $this->addElements(array($hora_presentacion));     

        /* AREAS Y SUBAREAS DEL BRIEF */
        $area_brief = new Zend_Form_Element_MultiCheckbox('area_brief');
        $area_brief->setLabel('Area:')
                ->setDecorators($decorator)                   
        		   ->setattrib('class', 'chk_area');
        $area_db = new Brief_Model_DbTable_Area(); 
        $c_areas = 0;       
        foreach($area_db->listar() as $retorno){
            $area_brief->addMultiOption($retorno->id_area, $retorno->nombre_area);     

            $this->addElements(array($area_brief));  

            /* SUBAREAS DEL BRIEF */
	        $subarea_brief = new Zend_Form_Element_MultiCheckbox('subarea_brief_'.$retorno->id_area);
	        $subarea_brief->setLabel('Sub-Areas:')
        			  	  ->setAttrib('class', 'chk_subarea subarea_'.$retorno->id_area.'')        			  	  
                ->setDecorators($decorator)                           
        			  	  ->setAttrib('disabled', 'disabled');        	
            $subarea_db = new Brief_Model_DbTable_Subarea();
            foreach($subarea_db->listar_por_area($retorno->id_area) as $sbarea){				
				$subarea_brief->addMultiOption($sbarea->id_subarea, $sbarea->nombre_subarea);   
				$this->addElements(array($subarea_brief));                	
            }
            unset($sbarea, $subarea_db);
            $c_areas = $c_areas + 1;
        }
        unset($retorno, $area_db);          

        /* CAMPAÑA */
        $campania_brief = new Zend_Form_Element_Text('campania_brief');
        $campania_brief->setLabel('Campaña:')
                       ->setAttrib('id', 'campania_brief')
        			   ->setRequired(true)
        			   ->setAttrib('maxlength', '1000')
                ->setDecorators($decorator)                   
        			   ->setAttrib('class', 'required');
        $this->addElements(array($campania_brief)); 

        /* ANTECEDENTES */
        $antecedentes_brief = new Zend_Form_Element_Textarea('antecedentes_brief');
        $antecedentes_brief->setLabel('Antecedentes:')
                           ->setAttrib('id', 'antecedentes_brief')
        				   ->setRequired(true)
        				   ->setAttrib('cols', '30')
                ->setDecorators($decorator)                   
    					   ->setAttrib('rows', '4')
    					   ->setAttrib('maxlength', '5000')
        				   ->setAttrib('class', 'required editor');        				   
        $this->addElements(array($antecedentes_brief)); 

        /* OBJETIVO COMERCIAL */
        $objetivo_comercial = new Zend_Form_Element_Text('objetivo_comercial_brief');
        $objetivo_comercial->setLabel('Objetivo Comercial:')
                           ->setAttrib('id', 'objetivo_comercial_brief')
        				   ->setRequired(true)
                ->setDecorators($decorator)                   
        				   ->setAttrib('class', 'required')
        				   ->setAttrib('maxlength', '1000');
        $this->addElements(array($objetivo_comercial)); 

        /* TARGET */
        $target = new Zend_Form_Element_Text('target_brief');
        $target->setLabel('Target:')
                           ->setAttrib('id', 'target_brief')
        				   ->setRequired(true)
                ->setDecorators($decorator)                   
        				   ->setAttrib('class', 'required')
        				   ->setAttrib('maxlength', '1000');
        $this->addElements(array($target)); 

        /* OBJETIVO DE COMUNICACIÓN	*/
        $objetivo_comunicacion = new Zend_Form_Element_Text('objetivo_comunicacion_brief');
        $objetivo_comunicacion->setLabel('Objetivo de Comunicación:')
        				   ->setRequired(true)
                           ->setAttrib('id', 'objetivo_comunicacion_brief')
        				   ->setAttrib('class', 'required')
                ->setDecorators($decorator)                   
        				   ->setAttrib('maxlength', '1000');
        $this->addElements(array($objetivo_comunicacion)); 

        /* PRINCIPAL BENEFICIO A COMUNICAR */
        $beneficio_comunicar = new Zend_Form_Element_Text('beneficio_comunicar_brief');
        $beneficio_comunicar->setLabel('Principal Beneficio a Comunicar:')
        				   ->setRequired(true)
                           ->setAttrib('id', 'beneficio_comunicar_brief')
        				   ->setAttrib('class', 'required')
                ->setDecorators($decorator)                   
        				   ->setAttrib('maxlength', '1000');
        $this->addElements(array($beneficio_comunicar)); 

        /* RESPUESTA DESEADA */
        $respuesta_deseada = new Zend_Form_Element_Text('respuesta_consumidor_brief');
        $respuesta_deseada->setLabel('Respuesta Deseada del Consumidor:')
        				   ->setRequired(true)
                           ->setAttrib('id', 'respuesta_consumidor_brief')
        				   ->setAttrib('class', 'required')
                ->setDecorators($decorator)                   
        				   ->setAttrib('maxlength', '1000');
        $this->addElements(array($respuesta_deseada)); 

        /* TONO Y ESTILO */
        $tono = new Zend_Form_Element_Text('tono_brief');
        $tono->setLabel('Tono y Estilo:')
        				   ->setRequired(true)
                           ->setAttrib('id', 'tono_brief')
                ->setDecorators($decorator)                   
        				   ->setAttrib('class', 'required')
        				   ->setAttrib('maxlength', '1000');
        $this->addElements(array($tono)); 

        /* PIEZAS TRABAJAR */
        $piezas_trabajar = new Zend_Form_Element_Text('piezas_trabajar_brief');
        $piezas_trabajar->setLabel('Piezas a Trabajar:')
        				   ->setRequired(true)
                           ->setAttrib('id', 'piezas_trabajar_brief')
                ->setDecorators($decorator)                   
        				   ->setAttrib('class', 'required')
        				   ->setAttrib('maxlength', '1000');
        $this->addElements(array($piezas_trabajar)); 

        /* PRESUPUESTO */
        $presupuesto = new Zend_Form_Element_Text('presupuesto_brief');
        $presupuesto->setLabel('Presupuesto:')
        				   ->setRequired(true)
                           ->setAttrib('id', 'presupuesto_brief')
        				   ->setAttrib('class', 'required')
                ->setDecorators($decorator)                   
        				   ->setAttrib('maxlength', '1000');
        $this->addElements(array($presupuesto)); 

        /* MANDATORIOS */
        $mandatorios = new Zend_Form_Element_Text('mandatorios_brief');
        $mandatorios->setLabel('Mandatorios:')
        				   ->setRequired(true)
                           ->setAttrib('id', 'mandatorios_brief')
                ->setDecorators($decorator)                   
        				   ->setAttrib('class', 'required')
        				   ->setAttrib('maxlength', '1000');
        $this->addElements(array($mandatorios)); 

        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large addBrief')
                ->setDecorators($decorator_submit)                   
              ->setLabel('CREAR BRIEF');
        $this->addElements(array($boton));         
	}

	
}

?>