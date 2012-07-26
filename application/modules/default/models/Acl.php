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
        $this->add(new Zend_Acl_Resource('default'));
        $this->add(new Zend_Acl_Resource('default:index'));
        $this->add(new Zend_Acl_Resource('default:error'));               
        $this->add(new Zend_Acl_Resource('default:tablero'));         
        $this->add(new Zend_Acl_Resource('hosting:index'));         
        $this->add(new Zend_Acl_Resource('hosting:cronjob'));         
      
        # [PERMISOS]
        $this->deny('visitante');
        $this->allow('visitante',array('default:index','default:error','hosting:cronjob'));        
        $this->deny('basico',array('hosting:index'));
        $this->allow('basico',array('default:tablero'));
        $this->allow('administrador',array('hosting:index'));        
    }
}