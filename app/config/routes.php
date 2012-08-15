<?php
/* SVN FILE: $Id: routes.php 6311 2008-01-02 06:33:52Z phpnut $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app.config
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 6311 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2008-01-02 00:33:52 -0600 (Wed, 02 Jan 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.thtml)...
 */

    Router::parseExtensions('xml');
	Router::connect('/', array('controller' => 'dashboard', 'action' => 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
/**
 * Then we connect url '/test' to our test controller. This is helpfull in
 * developement.
 */
	Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
	
	
	
	// Custom URL route
	Router::connect('/music/([^/]*)/_/([^/]*)/\40edit$', array('controller' => 'lyrics', 'action' => 'edit')); 
	
    Router::connect('/music/([^/]*)/_/([^/]*)$', array('controller' => 'tracks', 'action' => 'track')); 
    /*print_r( Router::connect('/music/:artist/_/:track', array('controller' => 'tracks', 'action' => 'track'),
    array('artist'=>'.*','track'=>'.*')
    ) ); */
    
    Router::connect('/music/([^/]*)/([^/]*)$', array('controller' => 'albums', 'action' => 'album')); 
    
    Router::connect('/music/([^/]*)$', array('controller' => 'artists', 'action' => 'artist'));

    Router::connect('/music$', array('controller' => 'stats', 'action' => 'music'));
    
    //Router::connect('/videos/([^/]*)/_/([^/]*)$', array('controller' => 'mashups', 'action' => 'videos'));
    
    Router::connect('/([a-z]|9)$', array('controller' => 'artists', 'action' => 'dir'));
    
    Router::connect('/add$', array('controller' => 'lyrics', 'action' => 'add'));
   
    Router::connect('/user/\40edit', array('controller' => 'users', 'action' => 'edit'));
    Router::connect('/user/*', array('controller' => 'users', 'action' => 'view'));
    //Router::connect('/user', array('controller' => 'users', 'action' => 'index'));
    
    Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
    Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));

    Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
    Router::connect('/recover', array('controller' => 'users', 'action' => 'recover'));
    Router::connect('/recover/(.*)$', array('controller' => 'recovers', 'action' => 'newpwd'));

    Router::connect('/noaccess', array('controller' => 'users', 'action' => 'noaccess'));

    Router::connect('/migrate/(.*)$', array('controller' => 'migrates', 'action' => 'update'));
    
    //coming soon
    //Router::connect('/request', array('controller' => 'pages', 'action' => 'display', 'request'));
    
    Router::connect('/search', array('controller' => 'pages', 'action' => 'display', 'search'));
    
    Router::connect('/sitemap', array('controller' => 'tracks', 'action' => 'sitemap'));
    
?>
