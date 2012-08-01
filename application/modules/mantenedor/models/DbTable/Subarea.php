<?php

class Mantenedor_Model_DbTable_Subarea extends Zend_Db_Table_Abstract
{

    protected $_name = 'subarea';
    
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('s'=>$this->_name),array('id_subarea','nombre_subarea'))
                ->joinInner(array('a'=>'area'),'s.id_area = a.id_area',array('a.nombre_area'))
                ->order('s.id_subarea');
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
                    ->where('id_subarea = ?',$id_registro);
            return $consulta->query()->fetch();
        }else return false;
        
    }
    public function actualizar($datos,$id_registro){
        if(is_array($datos) && is_numeric($id_registro)){
            if($this->update($datos,'id_subarea = '.$id_registro)) return true; else return false;
        }else return false;
    }
    public function eliminar($id_registro){
        if(is_numeric($id_registro)){
            if($this->delete('id_subarea = '.$id_registro)) return true; else return false;
        }else return false;
    }
}

