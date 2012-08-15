<?php
class DashboardController extends AppController {

    var $name = 'Dashboard';
    var $uses = array();
    var $helpers = array('Javascript');
                 
    function home() {
        $this->pageTitle = 'Portada';

        $data = ClassRegistry::init('Track')->find('all', array('limit' => 10, 'order' => 'Track.created DESC', 'recursive'=> '0')); 
        $this->set('lastTracks', $data );
        
        App::import('Vendor', 'fecha');
        $from = fecha('last week');
        $to = fecha('now');
        
        $n = 5;
        $this->set('topTracks', ClassRegistry::init('Stat')->TopTracks($from,$to,$n) );

    }
    
    function index() {
        $this->pageTitle = 'Panel';
    
    
    }
}
?>
