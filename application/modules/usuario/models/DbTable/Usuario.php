<?php

class Usuario_Model_DbTable_Usuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuario';
    
    public function guardar($datos){
        if(is_array($datos)){
            if($this->existeEmail($datos['email_usuario'])){
                if($this->insert($datos)) return true; else return false;
            }else return false;
        }else return false;
    }
    public function existeEmail($email){
        if(is_string($email)){
            $consulta = $this->select()
                    ->setIntegrityCheck(true)
                    ->from($this->_name,'*')
                    ->where('email_usuario = ?',$email);
            if($consulta->query()->rowCount()>0) return false; else return true;
           
        }else return false;
    }
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('u'=>'usuario'),array('id'=>'u.id_usuario','nombre'=>'u.nombre_usuario','email'=>'u.email_usuario'))
                ->joinInner(array('uc'=>'usuario_cargo'),'u.id_cargo = uc.id_cargo',array('cargo'=>'uc.nombre_cargo'))
                ->joinInner(array('ut'=>'usuario_tipo'),'u.id_tipo = ut.id_tipo',array('tipo'=>'ut.nombre_tipo'));
        return $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }
    public function obtener($id_usuario){
        if(is_numeric($id_usuario)){
            $consulta = $this->select()
                    ->setIntegrityCheck(false)
                    ->from($this->_name,'*')
                    ->where('id_usuario = ?',$id_usuario);
            return $consulta->query()->fetch();
        }else return false;
    }
    public function actualizar($datos,$id_usuario){
        if(is_array($datos) & is_numeric($id_usuario)){
            if($this->update($datos,'id_usuario = '.$id_usuario)) return true; else return false;
        }else return false;
    }
    public function eliminar($id_usuario){
        if(is_numeric($id_usuario)){
            if($this->delete('id_usuario = '.$id_usuario)) return true; else return false;
        }else return false;
    }
}

