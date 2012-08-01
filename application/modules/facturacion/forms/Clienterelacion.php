<?php

class Facturacion_Form_Clienterelacion extends Zend_Form
{

    public function init()
    {
        $this->setName('clienterelacion');
        $this->setAttrib('id','formulario');
        /* USUARIO */
        $usuario = new Zend_Form_Element_Select('id_usuario');
        $usuario->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Usuario:');        
        $usuario_db = new Usuario_Model_DbTable_Usuario();
        $usuario->addMultiOption(0,'');          
        foreach($usuario_db->listar() as $retorno){
            $usuario->addMultiOption($retorno->id,$retorno->nombre);
        }
        unset($retorno,$usuario_db);  
        /* TIPO */
        $tipo = new Zend_Form_Element_Select('id_rol');
        $tipo->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Rol:');
        $tipo->addMultiOptions(array(''=>'','1'=>'Director de Cuentas','2'=>'Ejecutivo de Cuentas','3'=>'Asistente de Cuentas'));

        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');
        
        $this->addElements(array($usuario,$tipo,$boton));            
    }


}

