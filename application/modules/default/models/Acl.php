<?php

class Model_Acl  extends Zend_Acl
{
    public function __construct() 
    {
        # [ROLES]
        $this->addRole(new Zend_Acl_Role('visitante'));
        $this->addRole(new Zend_Acl_Role('basico'),array('visitante'));             
        $this->addRole(new Zend_Acl_Role('administrador'),array('visitante','basico'));             
        
        # [RECURSOS]          
        $this->add(new Zend_Acl_Resource('default:index'));
        $this->add(new Zend_Acl_Resource('default:error'));               
        $this->add(new Zend_Acl_Resource('default:tablero'));         
        $this->add(new Zend_Acl_Resource('default:perfil'));         
        $this->add(new Zend_Acl_Resource('hosting:index'));         
        $this->add(new Zend_Acl_Resource('hosting:cronjob'));         
        $this->add(new Zend_Acl_Resource('usuario:index'));         
        $this->add(new Zend_Acl_Resource('mantenedor:region'));         
        $this->add(new Zend_Acl_Resource('mantenedor:provincia'));         
        $this->add(new Zend_Acl_Resource('mantenedor:comuna'));         
        $this->add(new Zend_Acl_Resource('mantenedor:area'));
        $this->add(new Zend_Acl_Resource('mantenedor:subarea'));
        $this->add(new Zend_Acl_Resource('mantenedor:tipocliente'));
        $this->add(new Zend_Acl_Resource('mantenedor:rol'));
        $this->add(new Zend_Acl_Resource('mantenedor:actividad'));
        $this->add(new Zend_Acl_Resource('mantenedor:proyecto'));
        $this->add(new Zend_Acl_Resource('mantenedor:cargo'));
        $this->add(new Zend_Acl_Resource('facturacion:index'));
        $this->add(new Zend_Acl_Resource('facturacion:cliente'));
        $this->add(new Zend_Acl_Resource('facturacion:proveedor'));
        $this->add(new Zend_Acl_Resource('facturacion:gantt'));
        $this->add(new Zend_Acl_Resource('facturacion:facturas-emitidas'));
        $this->add(new Zend_Acl_Resource('brief:index'));
        $this->add(new Zend_Acl_Resource('brief:of')); 
        $this->add(new Zend_Acl_Resource('brief:oc')); 
        $this->add(new Zend_Acl_Resource('timesheet:index')); 
        $this->add(new Zend_Acl_Resource('timesheet:aviso')); 

        # [PERMISOS]
        $this->deny('visitante');
        $this->allow('visitante',array('default:index','default:error','hosting:cronjob','timesheet:aviso'));        
        $this->deny('basico',array('hosting:index'));
        $this->allow('basico',array('default:tablero','default:perfil','timesheet:index'));
        $this->allow('administrador',
                array('hosting:index',
                    'usuario:index',
                    'mantenedor:region',
                    'mantenedor:provincia',
                    'mantenedor:comuna',
                    'mantenedor:area',
                    'mantenedor:subarea',
                    'mantenedor:tipocliente',
                    'mantenedor:actividad',
                    'mantenedor:proyecto',
                    'mantenedor:rol',
                    'mantenedor:cargo',
                    'facturacion:index',
                    'facturacion:cliente',
                    'facturacion:proveedor',
                    'facturacion:gantt',
                    'facturacion:facturas-emitidas',
                    'brief:index',
                    'brief:of',
                    'brief:oc'));        
    }
}