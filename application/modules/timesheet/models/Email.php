<?php

class Timesheet_Model_Email
{
    public function seispm($id_usuario){        
        if(is_numeric($id_usuario)){
            /* USUARIO */
            $usuario = new Usuario_Model_DbTable_Usuario();
            $datos = (object)$usuario->obtener($id_usuario);
            /* EMAIL */
            $email = new Zend_Mail('UTF-8');
            $mensaje = utf8_decode('
                <style>body{font-family: "Arial",sans-serif; font-size: 12px}</style>
                <h2 style="padding: 10px; background: #E2442D; color: #fff;">RECORDATORIO DE TIMESHEET</h2>
                Estimado: <strong>'.$datos->nombre_usuario.'</strong>,<br /><br />
                Tenemos el agrado de recordarte que debes completar tu <strong>TimeSheet</strong>.<br /><br />
                Te invito a ingresar en la siguiente URL: <a href="" target="_blank">http://gestion.cionline.cl</a>. Tus datos de acceso a la plataforma son los siguientes:<br /><br />
                Usuario: <strong>'.$datos->email_usuario.'</strong><br />
                Clave: <strong>'.$datos->clave_usuario.'</strong><br /><br />
                <em>Nos vemos mañana a las 9 am en caso que no completes el <strong>TimeSheet</strong> hoy.</em>                
                ');
            $email->setReplyTo('no-reply@creatividadeinteligencia.cl','Creatividad e Inteligencia');
            $email->setBodyHtml($mensaje);
            $email->setFrom('no-reply@creatividadeinteligencia.cl','Creatividad e Inteligencia');
            #$email->addTo("jramirez@creatividadeinteligencia.cl","Jonathan Ramírez");
            $email->addTo($datos->email_usuario,$datos->nombre_usuario);
            $email->setSubject("Recordatorio Timesheet ".date('d-m-Y')." a las 6 pm");
            $email->send();
        }else return false;
    }

}

