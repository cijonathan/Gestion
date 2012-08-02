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
        $rol = new Zend_Form_Element_Select('id_rol');
        $rol->setRequired(true)
                ->setAttrib('class','required span4')
                ->setLabel('Rol:');
        $rol_db = new Mantenedor_Model_DbTable_Rol();
        $rol->addMultiOption(0,'');         
        foreach($rol_db->listarRolCliente() as $retorno){
            $rol->addMultiOption($retorno->id_rol,$retorno->nombre_rol);
        }        
        unset($retorno,$rol_db);  

        /* BOTON */
        $boton = new Zend_Form_Element_Submit('Enviar');
        $boton->setAttrib('class','btn btn-primary btn-large')
              ->setLabel('GUARDAR');
        
        $this->addElements(array($usuario,$rol,$boton));            
    }


}

