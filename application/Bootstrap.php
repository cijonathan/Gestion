<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
   protected function _initAutoLoad(){
        /* [REGISTRO DE MODULOS] */
        $modulos = new Zend_Application_Module_Autoloader(array(
                'namespace'=>'',
                'basePath'=>APPLICATION_PATH.'/modules/default'
        ));   
        /* [AUTH] */
        if(Zend_Auth::getInstance()->hasIdentity()){
            
            $id_tipo =  Zend_Auth::getInstance()->getStorage()->read()->id_tipo;
            
            if($id_tipo == 1) $nombre_tipo = 'administrador';           
            if($id_tipo == 2) $nombre_tipo = 'basico';           
            
            Zend_Registry::set('id_usuario', Zend_Auth::getInstance()->getStorage()->read()->id_usuario);            
            Zend_Registry::set('nombre_usuario', Zend_Auth::getInstance()->getStorage()->read()->nombre_usuario);            
            Zend_Registry::set('email_usuario', Zend_Auth::getInstance()->getStorage()->read()->email_usuario);            
            Zend_Registry::set('clave_usuario', Zend_Auth::getInstance()->getStorage()->read()->clave_usuario);               
            Zend_Registry::set('id_tipo',$id_tipo);
            Zend_Registry::set('id_cargo', Zend_Auth::getInstance()->getStorage()->read()->id_cargo);
            Zend_Registry::set('rol_acl',$nombre_tipo);
        }else{
            Zend_Registry::set ('rol_acl','visitante');                 
        }    
        /* [ACL] */
        $this->acl = new Model_Acl();
        $controlador = Zend_Controller_Front::getInstance();
        $controlador->registerPlugin(new Plugin_Acceso($this->acl));        
        return $modulos;
    }
    protected function _initView(){
        $vista = new Zend_View();
        /* [META] */    
        $vista->headMeta()
                ->setHttpEquiv('Content-Language', 'es')
                ->setHttpEquiv('Content-Type', 'text/html; charset=UTF-8')                
                ->appendName('title','')
                ->appendName('author', 'Creatividad e Inteligencia')
                ->appendName('description','')
                ->appendName('keywords','')
                ->appendName('robots','index,follow');
        /* [TITLE] */
        $vista->headTitle('EXTRANET de GESTIÓN');   
        /* CSS */        
        $vista->headLink()
                ->appendStylesheet('/css/bootstrap-responsive.css')
                ->appendStylesheet('/css/bootstrap.css')
                ->appendStylesheet('/css/bootstrap.datepicker.css')  
                ->appendStylesheet('/css/bootstrap.timepicker.css')                
                ->appendStylesheet('/css/estilo.css');
        /* [JS] */
        $vista->headScript()
                ->appendFile('/js/jquery.js') 
                ->appendFile('/js/jquery.bootstrap.js') 
                ->appendFile('/js/jquery.bootstrap.datepicker.js')
                ->appendFile('/js/jquery.bootstrap.timepicker.js')                 
                ->appendFile('/js/jquery.validate.js') 
                ->appendFile('/js/jquery.ci.js'); 
        return $vista;
    }  
}

