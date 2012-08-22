<?php

class Timesheet_Model_DbTable_Timesheet extends Zend_Db_Table_Abstract
{

    protected $_name = 'timesheet';
    
    public function HoraHoy($id_usuario){       
        if(is_numeric($id_usuario)){
            $consulta = $this->select()
                    #SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `hora_timesheet` ) ) ) AS total_time   FROM `timesheet`
                    ->from($this->_name,array('total'=>'SEC_TO_TIME(SUM(TIME_TO_SEC(hora_timesheet)))'))
                    ->where('id_usuario = ?', $id_usuario)
                    ->where('registro_timesheet = ?',date('Y-m-d'));
            return $consulta->query()->fetch(Zend_Db::FETCH_OBJ);
        }else return false;
    }
    public function listar($id_usuario){
        if(is_numeric($id_usuario)){
            $consulta = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('t'=>$this->_name),array('hora'=>'t.hora_timesheet','id'=>'t.id_timesheet'))
                    ->joinInner(array('p'=>'proyecto'),'t.id_proyecto = p.id_proyecto',array('proyecto'=>'p.nombre_proyecto'))
                    ->joinInner(array('a'=>'actividad'),'t.id_actividad = a.id_actividad',array('actividad'=>'a.nombre_actividad'))
                    ->joinInner(array('c'=>'cliente'),'p.id_cliente = c.id_cliente',array('cliente'=>'c.nombre_cliente'))
                    ->where('t.id_usuario = ?', $id_usuario)
                    ->where('t.registro_timesheet = ?',date('Y-m-d'));
            return $consulta->query()->fetchAll(Zend_Db::FETCH_OBJ);
        }else return false;
    }
    public function listarOtros($id_usuario){
        if(is_numeric($id_usuario)){
            $consulta = $this->select()
                    ->setIntegrityCheck(false)
                    ->from(array('t'=>$this->_name),array('hora'=>'t.hora_timesheet','fecha'=>'t.registro_timesheet'))
                    ->joinInner(array('p'=>'proyecto'),'t.id_proyecto = p.id_proyecto',array('proyecto'=>'p.nombre_proyecto'))
                    ->joinInner(array('a'=>'actividad'),'t.id_actividad = a.id_actividad',array('actividad'=>'a.nombre_actividad'))
                    ->joinInner(array('c'=>'cliente'),'p.id_cliente = c.id_cliente',array('cliente'=>'c.nombre_cliente'))
                    ->where('t.id_usuario = ?', $id_usuario)
                    ->where('t.registro_timesheet <> ?',date('Y-m-d'))
                    ->order('t.registro_timesheet DESC')
                    ->limit(20);
            
            $datos = array();
            
            foreach($consulta->query()->fetchAll(Zend_Db::FETCH_OBJ) as $retorno){
                $fila = new stdClass();
                $fila->hora = $retorno->hora;
                $fecha = new Zend_Date($retorno->fecha,'Y-m-d');
                $fila->fecha = $fecha->toString('d-m-Y');
                $fila->proyecto = $retorno->proyecto;
                $fila->actividad = $retorno->actividad;
                $fila->cliente = $retorno->cliente;
                
                $datos[] = $fila;
            }
            return $datos;
        }else return false;    
    }    
    public function guardar($datos){
        if(is_array($datos)){
            if($this->validaCantidadHoras($datos['id_usuario'],$datos['registro_timesheet'],$datos['hora_timesheet'])){
                if($this->insert($datos)){
                    return true;
                }else return false;
            }else return false;
        }else return false;
    }
    public function eliminar($id_registro){
        if(is_numeric($id_registro)){
            if($this->delete('id_timesheet = '.$id_registro)) return true; else return false;
        }else return false;
    }
    private function validaCantidadHoras($id_usuario,$fecha,$hora){
        if(is_numeric($id_usuario) && is_string($fecha) && is_string($hora)){
            $consulta = $this->select()
                    ->from($this->_name,array('total'=>'SEC_TO_TIME(SUM(TIME_TO_SEC(hora_timesheet)))'))
                    ->where('id_usuario = ?',$id_usuario)
                    ->where('registro_timesheet = ?',$fecha);
            $datos = $consulta->query()->fetch(Zend_Db::FETCH_OBJ);
            /* SUMATORIA */
            $total = split(':',$datos->total);            
            $hora = split(':',$hora);
            $horas = $total[0]+$hora[0];
            $minutos = $total[1]+$hora[1];
            /* VALIDA */
            if(($horas <= '9' && $minutos <= '00') || ($horas <= '8' && $minutos <= '60')) return true; else return false;            
            
        }else return false;
    }
    public function avisoDiario($id_usuario){
        if(is_numeric($id_usuario)){
            $consulta = $this->select()
                    ->from($this->_name,array('total'=>'SEC_TO_TIME(SUM(TIME_TO_SEC(hora_timesheet)))'))   
                    ->where('id_usuario = ?',$id_usuario)
                    ->where('registro_timesheet = ?',date('Y-m-d'));
            
            $retorno = $consulta->query()->fetch(Zend_Db::FETCH_OBJ);
            
            if($retorno->total == '09:00:00') return false; else return true;
                    
        }else return false;
    }
}

