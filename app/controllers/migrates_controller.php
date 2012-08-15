<?php

App::import('Controller', 'Users');

class MigratesController extends AppController
{
    var $components = array('Email');
    var $uses = array('User','Migrate');
    
      public function update($random = null)
   {
      $this->pageTitle = 'Actualizar perfil';
     
      if ( $random == null )
      {  
        redirect('/');
      }
      
      $row = $this->Migrate->find("random = '$random'", array("id", "user_id"));
      
      if ( $row == null )
      {
          $this->redirect('/');
      } 
      else
      {
         // MOSTRAR FORMULARIO
         $this->set('random', $random);
         
         if ( empty( $this->data["User"] ) )
         {
            
            $data = $this->User->find('first',array('conditions'=>'id = '.$row["Migrate"]["user_id"],'recursive'=>-1));
            
            $this->data = $data;
         }
         else {
            // SI FORMULARIO COMPLETO, ACTUALIZAR PERFIL Y BORRAR MIGRATE
            
            $this->data['User']['id'] = $row['Migrate']['user_id'];
            
            if (empty($this->data['User']['new_passwd'])) {
                $this->data['User']['new_passwd'] = null;
            }
            
            $this->Sanitize = new Sanitize;
            
            $this->Sanitize->paranoid($this->data["User"]['username']);
            $this->Sanitize->paranoid($this->data["User"]['name']);
            
            //$this->__convertPasswords();
            UsersController::__convertPasswords();
           
            
             if ( $this->User->save($this->data["User"]) )
             {
                  $this->Migrate->del($row["Migrate"]["id"]);  //del the row
                  
                  
                //ok!
                //esto es solo para hacer el login, para nada más
                $this->data["User"]['passwd']=$this->data["User"]['new_passwd'];
                
                
                //login
                //$this->login();
                UsersController::login();
                  
             }
            
         }
         
         
      }
   }
   

   
   
   
   private function allusers()
   {
        ini_set('max_execution_time', 12000); // increase execution time
        $users = $this->User->find('all',array('recursive'=>-1,'fields'=>array('id','email'),'conditions'=>"passwd = 'migrado'"));

        foreach ($users as $user)   
        {   
            $this->Migrate = new Migrate;
            $data['Migrate']['user_id']  = $user['User']['id'];   //the user id
            $data['Migrate']['random']   = String::uuid();
           
            if ($this->Migrate->save($data['Migrate']) )
            {
                if ( $this->sendMigrate($user['User']['email'], $data['Migrate']['random']) ) 
                {
                    //$this->set('message', "Success. An email has been sent to: <b>".$this->data["User"]["email"]) . "</b>";
                    //$this->set('email', $this->data["User"]["email"]);
                    //$this->render('check', 'ajax');
                    //$this->render('migrateok');
                    
                    //OK
                }
            }

        }
        
   }
   
   
    /*  
    private function login() {
        $this->othAuth->login($this->params['data']['User']);
    }
    */
   
    private function sendMigrate($email, $random) 
    {
            
            $this->Email->to        = $email;
            $this->Email->subject   = 'Actualización en www.deletras.cl';
            //$this->Email->replyTo   = 'noreply@mononeurona.org';
            $this->Email->sendAs    = 'html';
            //$this->Email->template  = null;
            $this->Email->from      = 'noreply@deletras.cl';
            $this->Email->lineLength = 120;
            //$this->set('foo', 'Cake tastes good today'); 
            //Set the body of the mail as we send it.
            //Note: the text can be an array, each element will appear as a
            //seperate line in the message body.
            
            $url = 'http://'.$_SERVER['SERVER_NAME'].'/migrate/'.$random;
            
            $msg  = '<i>No respondas</i> este correo, fue enviado automáticamente. ';
  
            $msg .= "\n\n<br /><br />Estimado usuario, por si aún no lo sabes, Bitácora de Letras es ahora www.deLetras.cl . ";
            $msg .= "Nos gustaría que siguieras <i>participando activamente</i> del sitio, actualizando ";
            $msg .= "<strong>tus datos</strong> en la siguiente dirección (sólo tomará unos segundos): \n<br > ";
            $msg .= '<a href="'. "\n".$url .'">'.$url .'</a>';
            
            $msg .= "\n\n<br /><br />La nueva versión puede hacer que: \n<br />";
            $msg .= " - Escuches la <strong>música</strong> de una canción (vía www.goear.com)\n<br />";
            $msg .= " - Mires el <strong>video</strong> de una canción (vía www.youtube.com)\n<br />";
            $msg .= " - Solicites ayuda o recomendaciones a <i>la comunidad</i> con la nueva sección <strong>Solicitar</strong>\n<br />";
            $msg .= " - <strong>Inicies sesión</strong> con tu cuenta de <i>Facebook</i> (usando Facebook Connect)\n<br />";
            //$msg .= "y con la posibilidad de ver videos de canciones.";
              
//            $msg .= "Y no lo olvides, pronto habrán ¡muchas sorpresas!\n<br />";

            $msg .= "\n\n<br /><br />Atte. Equipo Desarrollador<br />\nhttp://".$_SERVER['SERVER_NAME'];
            
            //die($msg);
            
            if ( $this->Email->send($msg) ) 
            {
                return true; 
            } 
            else 
            {
                return false;
            }
    }
    
    /*
	private function __convertPasswords()
	{
	    if(!empty( $this->data['User']['new_passwd'] ) ){
            // we still want to validate the value entered in new_passwd
            // so we store the hashed value in a new data field which
            // we will later pass on to the passwd field in an 
            // afterSave() function 
		    $this->data['User']['new_passwd_hash'] = $this->othAuth->_getHashOf( $this->data['User']['new_passwd'] );
		}
	}
    */
}

?>
