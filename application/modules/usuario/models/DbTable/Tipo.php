<?php

class Usuario_Model_DbTable_Tipo extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuario_tipo';
    
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,'*')
                ->order('nombre_tipo');
        return $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }    

}

