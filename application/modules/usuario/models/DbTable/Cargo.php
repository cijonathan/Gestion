<?php

class Usuario_Model_DbTable_Cargo extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuario_cargo';
    
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name,'*')
                ->order('nombre_cargo');
        return $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }


}

