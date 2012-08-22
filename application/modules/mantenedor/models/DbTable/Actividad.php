<?php

class Mantenedor_Model_DbTable_Actividad extends Zend_Db_Table_Abstract
{

    protected $_name = 'actividad';
    
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,'*')
                ->order('id_actividad');
        return $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }
    public function guardar($datos){
        if(is_array($datos)){
            if($this->insert($datos)){
                return true;
            }else return false;
        }else return false;
    }
    public function obtener($id_registro){
        if(is_numeric($id_registro)){
            $consulta = $this->select()
                    ->setIntegrityCheck(false)
                    ->from($this->_name,'*')
                    ->where('id_actividad = ?',$id_registro);
            return $consulta->query()->fetch();
        }else return false;
        
    }
    public function actualizar($datos,$id_registro){
        if(is_array($datos) && is_numeric($id_registro)){
            if($this->update($datos,'id_actividad = '.$id_registro)) return true; else return false;
        }else return false;
    }
    public function eliminar($id_registro){
        if(is_numeric($id_registro)){
            if($this->delete('id_actividad = '.$id_registro)) return true; else return false;
        }else return false;
    }
}

