<?php

class Mantenedor_Model_DbTable_Provincia extends Zend_Db_Table_Abstract
{

    protected $_name = 'provincia';
    
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('p'=>$this->_name),array('id_provincia','nombre_provincia'))
                ->joinInner(array('r'=>'region'),'p.id_region = r.id_region',array('nombre_region'))
                ->order('p.id_region');
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
                    ->where('id_provincia = ?',$id_registro);
            return $consulta->query()->fetch();
        }else return false;
        
    }
    public function actualizar($datos,$id_registro){
        if(is_array($datos) && is_numeric($id_registro)){
            if($this->update($datos,'id_provincia = '.$id_registro)) return true; else return false;
        }else return false;
    }
    public function eliminar($id_registro){
        if(is_numeric($id_registro)){
            if($this->delete('id_provincia = '.$id_registro)) return true; else return false;
        }else return false;
    }
}

