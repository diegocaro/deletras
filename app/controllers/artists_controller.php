<?php

class ArtistsController extends AppController
{
    //var $uses = array('Artist');
    var $helpers = array('Ajax');
    
    function artist ($name)
    {
        $name = LinkHelper::toArtist($name);

        $albumstracks = $this->Artist->find('first', array('conditions' => array("Artist.code"=>$name),'recursive' => 1 ) );
       
        $this->set('albumstracks', $albumstracks );

        $this->pageTitle = $albumstracks['Artist']['name'];
        
    }
    
    function autocomplete ()
    {
        $name = Sanitize::escape($this->data['Artist']['name']);
        
        $this->set('artists',
            $this->Artist->findAll("Artist.name LIKE '{$name}%'",
            'Artist.name','Artist.name ASC',10,0,-1)
        );
        
        $this->layout = 'ajax';
    
    }
    
    function dir ($letter)
    {
        $this->pageTitle = strtoupper($letter) . ' - Música';
         
        if ($letter!='9')
        {
            $this->set('artists',
                $this->Artist->find('all', array('conditions' => "Artist.code LIKE '{$letter}%'",
                'fields'=>array('Artist.name'),
                'recursive'=>-1) )
            );
        }
        else
        {
            $this->set('artists',
                $this->Artist->find('all', array('conditions' => "Artist.code REGEXP '^[^a-zA-Z]'",
                'fields'=>array('Artist.name'),
                'recursive'=>-1) )
            );
        }
    
    }

}

?>
