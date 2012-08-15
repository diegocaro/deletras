<?php
App::import('Vendor', 'fecha');
class StatsController extends AppController
{

    function music()
    {
        $this->pageTitle = 'Música';
    
        $from = fecha('last monday');
        $to = fecha('next sunday');
        
        //echo $from;
        //echo $to;
        
        $this->set('top_tracks', $this->Stat->TopTracks($from,$to) );
        $this->set('top_artists', $this->Stat->TopArtists($from,$to) );
        $this->set('top_users', $this->Stat->TopUsers($from,$to) );
        $this->set('dateFrom', $from);
        $this->set('dateTo', $to);
    }
    
    
    function toptracksbyartist($id) {
        return $this->Stat->toptracksbyartist($id);
    }
 
    function topartists($n) {
        $from = fecha('last week');
        $to = fecha('now');
    
        return $this->Stat->TopArtists($from,$to,$n);
    }


}

?>
