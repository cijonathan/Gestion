<?php

class Hosting_Model_DbTable_Hostingplan extends Zend_Db_Table_Abstract
{

    protected $_name = 'hosting_plan';
    
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(true)
                ->from($this->_name,'*')
                ->order('nombre_plan');
        return $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }


}

