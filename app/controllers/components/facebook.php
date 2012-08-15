<?php
/**
* Facebook Component
* @author Matt Savarino
* @license MIT
* @version 0.1
*/
$GLOBALS['facebook_config']['debug'] = NULL;

class FacebookComponent extends Object
{
    var $api_key = "setyourfacebookapikey";
    var $secret = "setyourapisecret";
   
    function startup(&$controller)
    {
        App::import('Vendor', 'facebook/facebook');
       
        $controller->facebook =& new Facebook($this->api_key, $this->secret);
        $controller->set('facebook', $controller->facebook);
    }
}
?>
