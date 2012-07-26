<?php

class Hosting_Model_DbTable_Hostingestado extends Zend_Db_Table_Abstract
{

    protected $_name = 'hosting_estado';
    
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(true)
                ->from($this->_name,'*')
                ->order('nombre_estado');
        return $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }
    

}

