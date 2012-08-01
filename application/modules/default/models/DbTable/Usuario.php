<?php

class Default_Model_DbTable_Usuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuario';
    
    public function obtener($id_usuario){
        if(is_numeric($id_usuario)){
            $consulta = $this->select()
                    ->from($this->_name,array('nombre_usuario','clave_usuario','email_usuario'))
                    ->where('id_usuario = ?', $id_usuario);
            return $consulta->query()->fetch();
        }else return false;        
    }
    public function actualizar($datos,$id_registro){
        if(is_numeric($id_registro) && is_array($datos)){
            if($this->update($datos,'id_usuario = '.$id_registro)) return true; else return false;
        }else return false;
    }


}

