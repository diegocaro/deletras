<?php

class UsersController extends AppController
{
    var $uses = array('User','Recover');
    var $components = array('Email', 'RequestHandler');

    var $paginate = array('Track' => array('limit' => 40, 'recursive'=>0, 'order' => 'Artist.code ASC, Track.code ASC') );
    function login()
    {
        if ( $this->othAuth->sessionValid() ) {
            $this->redirect('/user/+edit');
            exit();        
        }
    
        $this->pageTitle = 'Iniciar sesión';
    
        if(isset($this->data['User']))
        {
            $auth_num = $this->othAuth->login();
            
            $auth_msg = $this->othAuth->getMsg($auth_num);

            $this->set('auth_msg', $auth_msg);
            
            $this->data['User']['passwd']='';
            
        }
        
        if ($this->RequestHandler->isAjax()) {
            $this->render('login_ajax');
        }
    }
    function logout()
    {
        $this->othAuth->logout();
        //$this->flash('You are now logged out!','/login');
        $this->logout_facebook();
        $this->redirect('/');
        exit();
    }

    function noaccess()
    {
        $this->flash("You don't have permissions to access this page.",'/login');
    } 
    
    function view($username)
    {
        $user = $this->User->find('first',array('conditions'=>array('username'=>$username) ) );
        $this->set('user', $user);
        
        //$Track = new Track;
        //$this->set('tracks', $Track->FindAllByUserId($user['User']['id']));
        //$this->User->Lyric->Track->find('all',array('conditions' => array('username'=>$username), 'limit' => 10 ) );
        $tracks = $this->paginate('Track',array('username'=>$username));
        $this->set(compact('tracks'));
        
        $this->pageTitle = 'Viendo a ' . $username;
        
    }
    
    /*
    function index()
    {
        App::import('Vendor', 'fecha');
        
        $this->pageTitle = 'Usuarios';
        
        $from = fecha('last month');
        $to = fecha('this month');
        
        
        $Lyric = new Lyric;
        
        $this->set('contributors', $Lyric -> TopContributors($from, $to) );
        
        
    }
    */
    
    /**
     * allows editing of a user record
     *
     * the Users controller only lets people edit their own records.  The usersmanager
     * controller is used for more detailed user record editing.
     *
     */
	function edit()
	{
        $id = $this->othAuth->user('id');
        $data = $this->User->FindById($id);
     
        $this->pageTitle = 'Edita tu perfil';
        
        $this->set('username', $data['User']['username']);
        
		if (empty($this->data)) {
	        $this->data = $this->User->FindById($id);
	        
	    } else {
	        $this->data['User']['id'] = $id;
	        
			$this->__convertPasswords();
			
			if ( $this->data['User']['email'] == $data['User']['email'] ) {
			    //si el mail no lo cambiamos, no lo mandamos a guardar
			    unset($this->data['User']['email']);
			}

	        if ($this->User->save($this->data)) {
	            //$this->flash('Your changes have been saved.','/' );
	            
	        }
	        else {
	            //si algo sale mal :)
	            
	            
	            
	        }
	        
	        
	        //viene de "si el mail no lo cambiamos"
	        if ( !isset($this->data['User']['email'])) {
		        $this->data['User']['email'] = $data['User']['email'];
		    }
	        
	        if ( isset($this->data['User']['new_passwd']) ) {
	            unset($this->data['User']['new_passwd']);
	            unset($this->data['User']['confirm_passwd']);
	        }
	        
	    }

	}

    function register()
    {

        if ( $this->othAuth->sessionValid() ) {
            $this->redirect('/user/+edit');
            exit();
        }
        
        $this->pageTitle = 'Regístrate';
        
        
        if (!empty($this->data))
        {
            if (empty($this->data['User']['new_passwd'])) {
                $this->data['User']['new_passwd'] = null;
            }
            
            $this->Sanitize = new Sanitize;
            
            $this->Sanitize->paranoid($this->data["User"]['username']);
            $this->Sanitize->paranoid($this->data["User"]['name']);
            
            $this->__convertPasswords();

            $this->data["User"]['active'] = 1;
            $this->data['User']['group_id'] = 1;
            //$this->data['User']['created'] = date('c');
            
            //$this->User->create($this->data["User"]);
            
            if ($this->User->save($this->data["User"]))
            {
                //ok!
                //esto es solo para hacer el login, para nada más
                $this->data["User"]['passwd']=$this->data["User"]['new_passwd'];
                $this->othAuth->login();
            }
            else 
            {
                //algo salio mal
            } 
            
            
        }
    }
    
    
   /*** Recover password check****/
   public function recover()
   {
        $this->pageTitle = 'Recuperar contraseña';
            
        $this->Sanitize = new Sanitize;

        $this->Sanitize->clean($this->data["User"]);
        
        if ( ! empty( $this->data["User"] ) )
        {
           $user_id = $this->User->field('id', array("email" => $this->data["User"]["email"] ));
           
           if ($user_id == null)
           {
                   $this->set('error_message', "Error: el email <i>" . $this->data["User"]["email"] . "</i> no existe en nuestra base de datos.");
                   //$this->render('check', 'ajax');
           }
           else
           {   
               $this->Recover = new Recover;                                                    //confirm model
               $this->data['Recover']['user_id']  = $user_id;   //the user id
               //$this->data['Recover']['random']   = $this->_genPassword(14);
               $this->data['Recover']['random']   = String::uuid();
               
               if ( $this->Recover->save($this->data['Recover']) )
               {
                   if ( $this->sendRecover($this->data["User"]['email'], $this->data['Recover']['random']) ) 
                   {
                       //$this->set('message', "Success. An email has been sent to: <b>".$this->data["User"]["email"]) . "</b>";
                       $this->set('email', $this->data["User"]["email"]);
                       //$this->render('check', 'ajax');
                       $this->render('recoverok');
                   }
               }
           }
        }
   }
   
    private function sendRecover($email, $random) 
    {
            
            $this->Email->to        = $email;
            $this->Email->subject   = 'deLetras Recupera tu contraseña';
            //$this->Email->replyTo   = 'noreply@mononeurona.org';
            $this->Email->sendAs    = 'html';
            $this->Email->template  = null;
            $this->Email->from      = 'noreply@deletras.cl';
            $this->Email->lineLength = 120;
            //$this->set('foo', 'Cake tastes good today'); 
            //Set the body of the mail as we send it.
            //Note: the text can be an array, each element will appear as a
            //seperate line in the message body.
            
            $url = 'http://'.$_SERVER['SERVER_NAME'].'/recover/'.$random;
            
            //echo $url;
            $msg  = 'No respondas este correo, se ha enviado para recuperar tu contraseña. Si tu no pediste recuperarla, simplemente ignora este correo. ';
            
            $msg .= "\n<br />\n<br />Para recuperar tu contraseña, visita ";         
            $msg .= '<a href="'. "\n".$url .'">'.$url .'</a>';
            $msg .= ' y sigue las instrucciones.';

            $msg .= '<br /><br />Atte. el equipo deLetras <br /><a href="http://'.$_SERVER['SERVER_NAME'].'">http://'.$_SERVER['SERVER_NAME'].'</a>';
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
    
    
    function login_facebook() {
        $fb_uid = $this->facebook->get_loggedin_user();
        if ($fb_uid!=null) {
            $user = $this->User->findByFbUid($fb_uid);
            
            //Si el usuario facebook ya existe en la base de datos
            if ($user) {
            
                //echo "listo, usuario logueado";
                //pr($user);
                $this->data = $user;
                $this->othAuth->login(true);
                
            }
            else {
            //Si no existe.
                $this->redirect(array('action'=>'link_facebook'));
            }
            
        }
    }
    
    function link_facebook() {
        $fb_uid = $this->facebook->get_loggedin_user();
        $user = $this->User->findByFbUid($fb_uid);
       
        //Usuario facebook existe y usuario no está en la base de datos
        if ($fb_uid!=null && !$user) {
            //echo "¡cruzar cuentas o agregar nueva!";

            if(isset($this->params['data']))
            {
                //Comprobar si el login de usuario deletras fue exitoso
                $this->othAuth->auto_redirect = false;
                $auth_num = $this->othAuth->login();

                $this->data['User']['passwd']='';
                
                if ($this->othAuth->sessionValid()) {
                    //linkear datos
                    $user = array('User'=>array() );
                    $user['User']['id'] = $this->othAuth->user('id');
                    $user['User']['fb_uid'] = $fb_uid;
                    
                    /* Suspendido hasta entender para que sirve.
                    $query = 'SELECT name, email_hashes FROM user WHERE uid=\''.$fb_uid.'\'';
                    $fbuser = $this->facebook->api_client->fql_query($query);
                    $fbuser = $fbuser[0];

                    if (is_array($fbuser['email_hashes'])) {
                        $user['User']['email_hash'] = $fbuser['email_hashes'][0];
                    }
                    else {
                        $user['User']['email_hash'] = $fbuser['email_hashes'];
                    }
                    */
                    
                    if ( $this->User->save($user) ) {
                        //Recargar nuevos datos de usuario
                        $this->othAuth->login();
                        $this->redirect('/');
                    }
                    else {
                        //error
                    }
                }
                else {
                    //mostrar mensaje de error en la página
                    $auth_msg = $this->othAuth->getMsg($auth_num);
                    $this->set('auth_msg', $auth_msg);
                }
                
                

            }
            
            $fbuser = $this->facebook->api_client->users_getInfo($fb_uid, array('name') );
            
            $this->set('fbname', $fbuser[0]['name']);
            
        
        }
        else {
            $this->cakeError('error404');
        }
    } 
    
    function register_facebook() {
        $fb_uid = $this->facebook->get_loggedin_user();
        $user = $this->User->findByFbUid($fb_uid);
        //pr($user);
        //Usuario facebook existe y usuario no está en la base de datos
        if ($fb_uid!=null && !$user) {
            $user = array( 'User'=>array() );
            
            $query = 'SELECT name, email_hashes FROM user WHERE uid=\''.$fb_uid.'\'';
            $fbuser = $this->facebook->api_client->fql_query($query);
            $fbuser = $fbuser[0];
            
            $user['User']['username'] = substr(Inflector::slug(Inflector::underscore($fbuser['name']), ''), 0, 20);
            $user['User']['name'] = $fbuser['name'];
            $user['User']['fb_uid'] = $fb_uid;
            //$user['User']['email'] = 'facebook_' . $fb_uid . '@deletras.cl';
            //$user['User']['email_hash'] = $fbuser['email_hashes'][0]; SUSPENDIDO HASTA ENTENDER PARA QUE SIRVE
            $user['User']['passwd'] = 'facebookuser';
            $user["User"]['active'] = 1;
            $user['User']['group_id'] = 1;
            
            while(true) {                
                $found = $this->User->findByUsername($user['User']['username']);
                
                if (!empty($found)) {
                    $user['User']['username'] .= 'fb';
                }
                else break;

            }
            
           
            if ($this->User->save($user)) {
                //$this->othAuth->auto_redirect = false;
                //hace automaticamente el redirect
                $this->data = $user;
                $this->othAuth->login(true);
                
                
            }
            else {
                //$this->register();
                $this->redirect('/register');
            }
            
            
        }
        else {
            $this->cakeError('error404');
        }
    }
    
    function logout_facebook() {
        $fb_uid = $this->facebook->get_loggedin_user();
        if ($fb_uid!=null) {
            $this->facebook->expire_session();
        }
    }

    
    
	function __convertPasswords()
	{
	    if(!empty( $this->data['User']['new_passwd'] ) ){
            // we still want to validate the value entered in new_passwd
            // so we store the hashed value in a new data field which
            // we will later pass on to the passwd field in an 
            // afterSave() function 
		    $this->data['User']['new_passwd_hash'] = $this->othAuth->_getHashOf( $this->data['User']['new_passwd'] );
		}
	}

}

?>
