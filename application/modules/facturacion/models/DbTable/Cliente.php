<?php

class Facturacion_Model_DbTable_Cliente extends Zend_Db_Table_Abstract
{

    protected $_name = 'cliente';
    
    public function listar($tipo = false){
        $consulta = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,'*')
                ->order('nombre_cliente');
        if($tipo == 1){
            $consulta->where("id_tipo = ?",1);            
            $consulta->orWhere("id_tipo = ?",3);
        }elseif($tipo == 2){
            $consulta->where("id_tipo = ?",2);
            $consulta->orWhere("id_tipo = ?",3);
        }else{
            $consulta->where("id_tipo = ?",3);
        }
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
    public function listarRelacion($id_cliente){
        if(is_numeric($id_cliente)){
            $consulta = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('ca'=>'cliente_asignacion'),array('id'=>'ca.id_registro'))
                    ->joinInner(array('u'=>'usuario'),'ca.id_usuario = u.id_usuario',array('nombre'=>'u.nombre_usuario'))
                    ->joinInner(array('r'=>'rol'),'ca.id_rol = r.id_rol',array('rol'=>'r.nombre_rol'))
                    ->where('ca.id_cliente = ?',$id_cliente)
                    ->order('ca.id_registro');
            return $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
        }else return false;
    }
    private function obtenerCliente($id_registro){
        if(is_numeric($id_registro)){
            $consulta = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('ca'=>'cliente_asignacion'),array('id'=>'ca.id_cliente'))                    
                    ->where('id_registro = ?', $id_registro);
            $datos = $consulta->query()->fetch(Zend_Db::FETCH_OBJ);
            return $datos->id;
        }else return false;
        
    }
    public function eliminaRelacion($id_registro){
        if(is_numeric($id_registro)){
            $base = new Default_Model_Personalizado();           
            $base = $base->base();
            $id_cliente = $this->obtenerCliente($id_registro);
            if($base->delete('cliente_asignacion','id_registro = '.$id_registro)){           
                return $id_cliente;
            }else return false;
        }else return false;        
    }

}

