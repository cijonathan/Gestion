<?php

class Facturacion_GanttController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $data = new Zend_Gdata();
        $login = new Zend_Gdata_ClientLogin();      
        
        $serviceName = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
        $cliente = $login->getHttpClient('jramirez@creatividadeinteligencia.cl','jramirez',$serviceName);
        $calendario = new Zend_Gdata_Calendar($cliente);  
        
        $evento = $calendario->newEventEntry();
        $evento->title = $calendario->newTitle('titulo');
        $evento->where = array($calendario->newWhere("Nagpur, India"));
        $evento->content  = $calendario->newContent("Some event content.");
        $cuando = $calendario->newWhen();
        $cuando->startTime = '2012-08-02T15:30:00.000-04:00';
        $cuando->endTime  = '2012-08-02T16:30:00.000-04:00';
        $evento->when = array($cuando);
        
        $calendario->insertEvent($evento);
        
    }


}

