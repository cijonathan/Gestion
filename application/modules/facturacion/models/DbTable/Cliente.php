<?php

class Facturacion_Model_DbTable_Cliente extends Zend_Db_Table_Abstract
{

    protected $_name = 'cliente';
    
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,'*')
                ->order('nombre_cliente');
        return $consulta->query()->fetchAll(Zend_db::FETCH_OBJ);
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
                    ->where('id_cliente = ?',$id_registro);
            return $consulta->query()->fetch();
        }else return false;
        
    }
    public function actualizar($datos,$id_registro){
        if(is_array($datos) && is_numeric($id_registro)){
            if($this->update($datos,'id_cliente = '.$id_registro)) return true; else return false;
        }else return false;
    }
    public function eliminar($id_registro){
        if(is_numeric($id_registro)){
            if($this->delete('id_cliente = '.$id_registro)) return true; else return false;
        }else return false;
    }
    public function guadarRelacion($datos){    
        if(is_array($datos)){
            $base = new Default_Model_Personalizado();           
            $base = $base->base();
            if($base->insert('cliente_asignacion',$datos)){
                return true;
            }else return false;
        }else return false;        
    }     

}

