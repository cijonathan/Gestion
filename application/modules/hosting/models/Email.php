<?php
class Hosting_Model_Email
{
    public function emailCronjob($dias,$id_hosting){
        if(is_numeric($dias) && is_numeric($id_hosting)){
            /* DATOS HOSTING */
            $hosting = new Hosting_Model_DbTable_Hosting();
            $datos = $hosting->obtenerDatosCronjob($id_hosting);
            /* CUERPO */
            $cuerpo = 'Estimado(a): <strong>'.$datos->nombre.'</strong><br /><br />';
            $cuerpo.= 'Informamos a usted que su cuenta de hosting que mantiene alojado el sitio web <strong>'.$datos->dominio.'</strong> tiene fecha de vencimiento el <strong style="color: #FF0000">'.$datos->vencimiento.'</strong><br /><br />';
            $cuerpo.= 'Contacte a nuestro equipo de soporte para renovar el servicio por el periodo '.$datos->periodo.'<br /><br />';
            $cuerpo.= '<strong>DATOS DEL SERVICIO:</strong><br /><br />';
            $cuerpo.= 'Dominio: '.$datos->dominio.'<br />';
            $cuerpo.= 'Plan: '.$datos->plan.'<br />';
            $cuerpo.= 'Valor: $ '.$datos->valor.'<br />';
            $cuerpo.= 'Baja del servicio: '.$datos->baja.'<br />';
            $cuerpo.= 'Eliminación del servicio: '.$datos->eliminacion.'<br /><br />';
            $cuerpo.= 'Le saluda atentamente,<br />';
            $cuerpo.= '<strong>soporte@creatividadeinteligencia.cl</strong>';          
            /* ZEND_EMAIL */
            $email = new Zend_Mail();
            $email->setFrom('soporte@creatividadeinteligencia.cl','Creatividad e Inteligencia');
            $email->addTo('jramirez@creatividadeinteligencia.cl','Jonathan Ramírez');
            $email->setSubject('[HOSTING] Renovación de plan de hosting '.$datos->dominio);
            $email->setBodyHtml($cuerpo,'utf-8');           
            if($email->send()){
                return true;
            }else{
                return false;
            }            
        }else return false;
        
    }
}

