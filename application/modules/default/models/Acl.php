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
        $this->add(new Zend_Acl_Resource('mantenedor:cargo'));
        $this->add(new Zend_Acl_Resource('facturacion:index'));
        $this->add(new Zend_Acl_Resource('facturacion:cliente'));
        $this->add(new Zend_Acl_Resource('brief:index'));

        # [PERMISOS]
        $this->deny('visitante');
        $this->allow('visitante',array('default:index','default:error','hosting:cronjob'));        
        $this->deny('basico',array('hosting:index'));
        $this->allow('basico',array('default:tablero','default:perfil'));
        $this->allow('administrador',
                array('hosting:index',
                    'usuario:index',
                    'mantenedor:provincia',
                    'mantenedor:comuna',
                    'mantenedor:area',
                    'mantenedor:subarea',
                    'mantenedor:tipocliente',
                    'mantenedor:rol',
                    'mantenedor:cargo',
                    'facturacion:index',
                    'facturacion:cliente',
                    'brief:index'));        
    }
}