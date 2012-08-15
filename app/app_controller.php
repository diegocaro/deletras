<?php

App::import('Core','Sanitize');
App::import('Helper', 'Link');


//Traducciones
App::import('Core', 'l10n');

class AppController extends Controller
{
  var $view = 'Theme';
  var $theme = 'default';
    //var $scaffold;

    //var $cacheAction = "1 hour";

    var $components  = array('othAuth', 'facebook'); 
    var $helpers = array('Html', 'OthAuth','Link', 'Form', 'Javascript', 'Ajax'); 
    
    
    //limitaciones a usuarios
    var $othAuthRestrictions = array( 'add','edit','delete','users', 'Requests/suscripted');


    function beforeFilter()
    {
      if ( strpos($this->Session->host, "watchlyrics") > -1 ) {
  $this->theme = 'watchlyrics';
      }

        $auth_conf = array(
                    'mode'  => 'oth',
                    'login_page'  => '/login',
                    'logout_page' => '/logout',
                    'access_page' => '/', //decia /user
                    'hashkey'     => 'Hola234at4toas',
                    'noaccess_page' => '/noaccess',
                    'strict_gid_check' => true);
        
        $this->othAuth->controller = &$this;
        $this->othAuth->init($auth_conf);
        $this->othAuth->check();
        

    }
    
}


?>
