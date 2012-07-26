<?php

class Hosting_Model_DbTable_Cliente extends Zend_Db_Table_Abstract
{

    protected $_name = 'cliente';
    
    public function listarHosting(){
        $consulta = $this->select()
                ->setIntegrityCheck(true)
                ->from($this->_name,array('id_cliente','nombre_cliente'))
                ->where('id_tipo = ?',1)
                ->orWhere('id_tipo = ?',3)
                ->order('nombre_cliente');
        return $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
    }    

}

