<?php

class Facturacion_Form_Cliente extends Zend_Form
{

    public function init()
    {
        $this->setName('cliente');
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
        
        /* CODIGO */
        $codigo = new Zend_Form_Element_Text('codigo_cliente');
        $codigo->setLabel('Codigo cliente:')   
                ->setDecorators($decorator)
                ->setAttrib('class','span1');         
        /* CODIGO */
        $codigo_proveedor = new Zend_Form_Element_Text('codigo_proveedor');
        $codigo_proveedor->setLabel('Codigo proveedor:')    
                ->setDecorators($decorator)                
                ->setAttrib('class','span1');         
        /* NOMBRE */
        $nombre = new Zend_Form_Element_Text('nombre_cliente');
        $nombre->setRequired(true)
                ->setLabel('Nombre cliente:')      
                ->setDecorators($decorator)                
                ->setAttrib('class','required span4');         
        /* RUT */
        $rut = new Zend_Form_Element_Text('rut_cliente');
        $rut->setRequired(true)
                ->setLabel('Rut cliente:') 
                ->setDecorators($decorator)                
                ->setAttrib('class','required span2');         
        /* RAZON SOCIAL */
        $razon = new Zend_Form_Element_Text('razon_social_cliente');
        $razon->setRequired(true)
                ->setLabel('Razon social cliente:')                
                ->setDecorators($decorator)                
                ->setAttrib('class','required span4');         
        /* TELEFONO */
        $telefono = new Zend_Form_Element_Text('telefono_cliente');
        $telefono->setRequired(true)
                ->setLabel('Teléfono cliente:')                
                ->setDecorators($decorator)                
                ->setAttrib('class','required span4');         
        /* GIRO */
        $giro = new Zend_Form_Element_Textarea('giro_cliente');
        $giro->setRequired(true)
                ->setLabel('Giro cliente:')   
                ->setAttrib('rows','2')
                ->setDecorators($decorator)                
                ->setAttrib('class','required span4');         
        /* DIRECCION */
        $direccion = new Zend_Form_Element_Textarea('direccion_cliente');
        $direccion->setRequired(true)
                ->setLabel('Dirección cliente:')   
                ->setAttrib('rows','2')
                ->setDecorators($decorator)                 
                ->setAttrib('class','required span4');         
        /* CONTACTO */
        $contacto = new Zend_Form_Element_Textarea('contacto_cliente');
        $contacto->setRequired(true)
                ->setLabel('Contacto cliente:')   
                ->setAttrib('rows','2')
                ->setDecorators($decorator)                 
                ->setAttrib('class','required span4');         
        /* FEE */
        $fee = new Zend_Form_Element_Text('contacto_cliente');
        $fee->setRequired(true)
                ->setLabel('FEE cliente:')  
                ->setDecorators($decorator)                 
                ->setAttrib('class','required span1');  
        /* COMUNA */
        $comuna = new Zend_Form_Element_Select('id_comuna');
        $comuna->setRequired(true)
                ->setAttrib('class','required span4')
                ->setDecorators($decorator)                 
                ->setLabel('Comuna:');        
        $comuna_db = new Mantenedor_Model_DbTable_Comuna();
        $comuna->addMultiOption('','');          
        foreach($comuna_db->listarCliente() as $retorno){
            $comuna->addMultiOption($retorno->id_comuna,$retorno->nombre_comuna.' - '.$retorno->nombre_provincia);
        }
        unset($retorno,$comuna_db);          
        /* TIPO */
        $tipo = new Zend_Form_Element_Select('id_tipo');
        $tipo->setRequired(true)
                ->setAttrib('class','required span4')
                ->setDecorators($decorator)                 
                ->setLabel('Tipo:');        
        $tipo_db = new Mantenedor_Model_DbTable_Tipocliente();
        $tipo->addMultiOption('','');          
        foreach($tipo_db->listar() as $retorno){
            $tipo->addMultiOption($retorno->id_tipo,$retorno->nombre_tipo);
        }
        unset($retorno,$tipo_db);          
        /* BOTON */
        $boton = new Zend_Form_Element_Submit('submit');
        $boton->setAttrib('class','btn btn-primary btn-large')
                ->setDecorators($decorator_submit)                 
              ->setLabel('GUARDAR');

        $this->addElements(array($codigo,$codigo_proveedor,$nombre,$rut,$razon,$giro,$direccion,$telefono,$contacto,$fee,$comuna,$tipo,$boton));
        
        /* Campo legend */
        $this->addDisplayGroup(array('codigo_cliente', 'codigo_proveedor', 'nombre_cliente','rut_cliente','razon_social_cliente', 'telefono_cliente','giro_cliente','direccion_cliente','contacto_cliente','id_comuna','id_tipo','submit'), 'birthday', array( 
            'legend' => 'Completar formulario' 
        ));
        $this->setDisplayGroupDecorators(array( 
            'FormElements', 
            'Fieldset', 
            // array('HtmlTag', array('class' => 'someclassname')) 
        ));        
        
    }


}

