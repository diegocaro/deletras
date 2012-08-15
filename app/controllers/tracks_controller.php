<?php

class TracksController extends AppController
{
    var $uses = array('Track','Stat');
    var $helpers = array('Ajax');
    
    function track ($artist,$track)
    {
        $artist = LinkHelper::toArtist($artist);
        $track = LinkHelper::toCode($track);

        $data = $this->Track->find('first',array('conditions'=>array("Track.code"=>$track, "Artist.code"=>$artist )) ) ;

        $this->set('track', $data );

        $query_video=array('artist'=>LinkHelper::tourl($data['Artist']['name']), 'track'=>LinkHelper::tourl($data['Track']['name']));
        $this->set('query_video', $query_video);
         
        $this->Stat->insert($data['Track']['id']);
        
        $this->pageTitle = $data['Track']['name'] . ', de ' . $data['Artist']['name'];
    }
    
    function autocomplete ()
    { 
        $name = Sanitize::escape($this->data['Track']['name']);
        
        $this->set('tracks',
            $this->Track->findAll("Track.name LIKE '{$name}%'",
            'DISTINCT Track.name','Track.name ASC',10,0,-1)
        );
        
        $this->layout = 'ajax';
    
    }
    
    function sitemap() {
        $this->layout = 'xml';
        
        $limit = 100;
        $total = $this->Track->find('count');
        $npages = ceil($total/$limit)+1;
        $urlbase = 'http://'.$_SERVER['SERVER_NAME'];
        /*
        echo $total;
        echo $limit;
        echo $npages;
        */
        header ("content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';
        
        
        for ($i = 0; $i < $npages; $i++) {
            $options = array(
                        'recursive' => 0,
                        'fields' => array('Artist.name', 'Track.name'),
                        'limit' => $limit,
                        'page' => $i
            );
        
            $tracks = $this->Track->find('all', $options);
            //pr($tracks);
            
            foreach($tracks as $track) {
                echo '<url>';
                $temp = $urlbase . LinkHelper::toTrack($track['Artist']['name'],$track['Track']['name']);
                echo '<loc>'.$temp.'</loc>';
                echo '</url>';
            }
        }
        
        echo '</urlset>';
        exit();
        
    }

}

?>
