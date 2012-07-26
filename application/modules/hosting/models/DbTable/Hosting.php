<?php

class Hosting_Model_DbTable_Hosting extends Zend_Db_Table_Abstract
{

    protected $_name = 'hosting';
    
    public function guardar($datos){
        if(is_array($datos)){
            $objeto = (object)$datos;
            /* PROCESAR FECHA COBRO */
            $fecha = new Zend_Date($objeto->fecha_registro,'dd-MM-YYYY');
            $datos['fecha_registro'] = $fecha->toString('YYYY-MM-dd');
            $fecha->addYear(1);
            $datos['fecha_cobro'] = $fecha->toString('YYYY-MM-dd');
            if($this->insert($datos)){
                return true;
            }else return false;
        }else return false;
    }
    public function cronjob(){    
        /* CONSULTA */                            
        $consulta = $this->select()
                ->setIntegrityCheck(true)
                ->from($this->_name,'*');
        $datos = $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
        $parametro = new Zend_Date(Zend_Date::now(),'YYYY-MM-dd');
        if(count($datos)>0){
            foreach($datos as $retorno){
                /* FECHA */
                $base = new Zend_Date($retorno->fecha_cobro,'YYYY-MM-dd');
                $parametro = ($parametro->getTimestamp()-$base->getTimestamp())/(3600*24);
                /* EMAIL */
                $email = new Hosting_Model_Email();
                if($parametro == 2){               
                    $email->emailCronjob($parametro,$retorno->id_hosting);
                }elseif($parametro == 5){                    
                    $email->emailCronjob($parametro,$retorno->id_hosting);
                }elseif($parametro == 10){
                    $email->emailCronjob($parametro,$retorno->id_hosting);
                }elseif($parametro == 20){
                    $email->emailCronjob($parametro,$retorno->id_hosting);
                }elseif($parametro == 30){
                    $email->emailCronjob($parametro,$retorno->id_hosting);
                }elseif($parametro == 0){                    
                    $email->emailCronjobCI($parametro,$retorno->id_hosting);
                }

            }
        }else return false;
        unset($retorno,$datos,$consulta);
    }
    public function obtenerDatosCronjob($id_hosting){        
        if(is_numeric($id_hosting)){
            /* CONSULTA */
            $consulta = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('h'=>$this->_name),array('email'=>'h.hosting_email_alternativo','dominio'=>'h.dominio_hosting','fecha_cobro'=>'h.fecha_cobro'))
                    ->joinInner(array('c'=>'cliente'),'h.id_cliente = c.id_cliente',array('nombre_cliente'=>'c.nombre_cliente'))
                    ->joinInner(array('hp'=>'hosting_plan'),'h.id_plan = hp.id_plan',array('nombre_plan'=>'hp.nombre_plan','precio_plan'=>'hp.precio_plan','baja'=>'hp.baja_dia_plan','elimina'=>'hp.eliminacion_dia_plan'))
                    ->where('h.id_hosting = ?', $id_hosting);
            $datos = $consulta->query()->fetch(Zend_Db::FETCH_OBJ);
            /* ZEND_DATE */
            $fecha = new Zend_Date($datos->fecha_cobro,'YYYY-MM-dd');
            /* DATOS */
            $fila = new stdClass();
            $fila->nombre = $datos->nombre_cliente;
            $fila->dominio = str_replace('http://www.','',$datos->dominio);
            $fila->vencimiento = $fecha->toString('dd-MM-YYYY');
            $fila->periodo = $fecha->toString('YYYY').'/'.$fecha->addYear(1)->toString('YYYY');
            $fila->plan = $datos->nombre_plan;
            $fila->valor = number_format($datos->precio_plan,0,',','.');
            $fila->baja = $fecha->addDay($datos->baja)->toString('dd-MM-YYYY').' (00:01 hrs)';
            $fila->eliminacion = $fecha->addDay($datos->elimina)->toString('dd-MM-YYYY').' (00:00 hrs)';
            return $fila;            
            
        }else return false;
    }
    public function listar(){
        $consulta = $this->select()
                ->setIntegrityCheck(false)                
                ->from(array('h'=>$this->_name),array('id_hosting'=>'h.id_hosting','email'=>'h.hosting_email_alternativo','dominio'=>'h.dominio_hosting','fecha_cobro'=>'h.fecha_cobro'))
                ->joinInner(array('c'=>'cliente'),'h.id_cliente = c.id_cliente',array('nombre_cliente'=>'c.nombre_cliente'))
                ->order('h.fecha_cobro');
        #echo $consulta;
        $datos = array();
        foreach($consulta->query()->fetchAll(Zend_db::FETCH_OBJ) as $retorno){            
            $fila = new stdClass();
            $fila->email = $retorno->email;
            $fila->dominio = $retorno->dominio;   
            $fecha = new Zend_Date($retorno->fecha_cobro,'YYYY-MM-dd');
            $fila->cobro = $fecha->toString('dd-MM-YYYY');
            $fila->cliente = $retorno->nombre_cliente;            
            $fila->id = $retorno->id_hosting;            
            $datos[] = $fila;
        }
        return $datos;
    }  
    public function eliminar($id_hosting){
        if(is_numeric($id_hosting)){
            if($this->delete('id_hosting = '.$id_hosting)) return true; else return false;
        }else return false;
    }

}