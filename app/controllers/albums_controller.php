<?php

class AlbumsController extends AppController
{
    var $helpers = array('Ajax');

    function album ($artist,$album)
    {
        $artist = LinkHelper::toArtist($artist);
        $album = LinkHelper::toCode($album);
        
        $albumstracks = $this->Album->find('first',array('conditions'=>array("Album.code"=>$album, "Artist.code"=>$artist )) ) ;
        $this->set('albumstracks', $albumstracks );
        
        $albumsartist = $this->Album->find('all', array('conditions' => "Album.artist_id={$albumstracks['Artist']['id']}",'recursive' => -1 ) );
        $this->set('albumsartist', $albumsartist );
        
        $this->pageTitle = $albumstracks['Album']['name'] . ' - ' . $albumstracks['Artist']['name'];
    }
    
    function autocomplete ()
    { 
        $name = Sanitize::escape($this->data['Album']['name']);
        
        $this->set('albums',
            $this->Album->findAll("Album.name LIKE '{$name}%'",
            'DISTINCT Album.name','Album.name ASC',10,0,-1)
        );
        
        $this->layout = 'ajax';
    
    }


}

?>
