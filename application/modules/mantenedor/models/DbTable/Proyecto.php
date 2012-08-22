<?php

class Mantenedor_Model_DbTable_Proyecto extends Zend_Db_Table_Abstract
{

    protected $_name = 'proyecto';
    
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('p'=>$this->_name),'*')
                ->joinInner(array('c'=>'cliente'),'p.id_cliente = c.id_cliente',array('cliente'=>'c.nombre_cliente'))
                ->order('p.id_proyecto');
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
                    ->where('id_proyecto = ?',$id_registro);
            return $consulta->query()->fetch();
        }else return false;
        
    }
    public function actualizar($datos,$id_registro){
        if(is_array($datos) && is_numeric($id_registro)){
            if($this->update($datos,'id_proyecto = '.$id_registro)) return true; else return false;
        }else return false;
    }
    public function eliminar($id_registro){
        if(is_numeric($id_registro)){
            if($this->delete('id_proyecto = '.$id_registro)) return true; else return false;
        }else return false;
    }
    public function obtenerProyectos($id_cliente){
        if(is_numeric($id_cliente)){
            $consulta = $this->select()
                    ->setIntegrityCheck(false)
                    ->from($this->_name)
                    ->where('id_cliente = ?',$id_cliente);
            return $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
        }else return false;     
    }
}

