<?php

class LyricsController extends AppController
{
    //var $uses = array ('Artist','Album','Track','User','Lyric','Ip');
    var $helpers = array('Ajax', 'Xml');
    var $components = array('RequestHandler');

    function add()
    {
        $this->pageTitle = 'Agrega una canción';

        $error = false;

        if (!empty($this->data)) 
        {
            
            if (empty($this->data['Artist']['name']))
            {
                $this->Lyric->Track->Artist->invalidate('name');
                $error=true;
            }

            if (empty($this->data['Track']['name']))
            {
                $this->Lyric->Track->invalidate('name');
                $error=true;
            }

            if (empty($this->data['Lyric']['text']))
            {
                $this->Lyric->invalidate('text');
                $error=true;
            }
  
  
            if (!$error)
            {
                $data = array();
                $data['Ip']['ip'] = $this->RequestHandler->getClientIP();
                $data['User']['id'] = $this->othAuth->user('id');
                
                // BEGIN INSERTAR ARTISTA
                $data['Artist'] = array (
                                 'name' => $this->data['Artist']['name']
                                );

                if (!$this->Lyric->Track->Artist->insert($data))
                {
                    $error=true;
                }
                // END INSERTAR ARTISTA


                // BEGIN INSERTAR ALBUM
                if (! empty ($this->data['Album']['name']) )
                {
                  $data['Album'] = array (
                                 'name' => $this->data['Album']['name'],
                                 //'year' => (int)$this->data['Album']['year'],
                                 'artist_id' => $data['Artist']['id']
                                );
                                
                   if (!$this->Lyric->Track->Album->insert($data))
                   {
                    $error=true;
                   }
                }
                // END INSERTAR ALBUM
    
    
                // BEGIN INSERTAR IP
                if (!$this->Lyric->Ip->insert($data))
                {
                    $error = true;
                }
                // END INSERTAR IP
                
                
                // BEGIN INSERTAR TRACK
                $data['Track'] = array (
                                 'name' => $this->data['Track']['name'],
                                 'artist_id' => $data['Artist']['id'],
                                 'user_id' => $data['User']['id'],
                                 'ip_id' => $data['Ip']['id']
                                );
                if (! empty ($this->data['Album']['name']) )
                {
                    $data['Album'] = array (
                                 'Album' => array($data['Album']['id'])
                                );
                }
                
                if(!$this->Lyric->Track->insert($data))
                {
                    $error = true;
                }
                // END INSERTAR TRACK

                // INSERTAR LYRIC
                if (!$error)
                {
                    $data['Lyric'] = array (
                                   'user_id' => $data['User']['id'],
                                   'track_id' => $data['Track']['id'],
                                   'text' => $this->data['Lyric']['text'],
                                   'ip_id' => $data['Ip']['id']
                                  );
                    if ( $this->Lyric->insert ( $data ) )
                    {
                        // OK
                        //$this->set ("ok", true);
                        //$this->flash("OK canción enviada!",$this->toTrack($data['Artist']['name'],$data['Track']['name']));

                        
                        $this->redirect(LinkHelper::toTrack($data['Artist']['name'],$data['Track']['name']));
                        exit();
                    }
                } 
            }

        }

    } //end add
    
    function edit($artist,$track)
    {
        $artist = LinkHelper::toArtist($artist);
        $track = LinkHelper::toCode($track);  
        
        $tracks = $this->Lyric->Track->find("Track.code='$track' AND Artist.code='$artist'",array('*') );
 
        $data = array();
        
        if (!empty($this->data)) 
        {
            $data['User']['id'] = $this->othAuth->user('id');
            $data['Ip']['ip'] = $this->RequestHandler->getClientIP();
        
            if (empty($this->data['Lyric']['text']))
            {
                $this->Lyric->invalidate('text');
                
                //mostrar la letra enviada
                $tracks['Lyric'][0]['text']=$this->data['Lyric']['text'];
                
                $error=true;
            }
            else
            {
            
                // BEGIN INSERTAR IP
                if (!$this->Lyric->Ip->insert($data))
                {
                    $error = true;
                }
                // END INSERTAR IP
                
                $data['Lyric'] = array (
                           'user_id' => $data['User']['id'],
                           'track_id' => $tracks['Track']['id'],
                           'text' => $this->data['Lyric']['text'],
                           'ip_id' => $data['Ip']['id']
                          );
                if ( $this->Lyric->insert ( $data ) )
                {
                    // OK
                    //$this->set ("ok", true);
                    //$this->flash("OK canción editada!","/");
                    $this->redirect(LinkHelper::toTrack($tracks['Artist']['name'],$tracks['Track']['name']));
                    exit();
                }
                else
                {
                    //ERROR
                }
            
            }    
        }
        
        $this->set('tracks', $tracks);
        
        $this->pageTitle = 'Editando ' . $tracks['Track']['name'] . ', de ' . $tracks['Artist']['name'];
    }
    
    function getSong($artist, $track) {
        $artist = LinkHelper::toArtist($artist);
        $track = LinkHelper::toCode($track);  
        
        $lyrics = $this->Lyric->Track->find('first', array('conditions' => array('Track.code' => $track, 'Artist.code'=>$artist), 'fields' => array('Artist.name', 'Track.name'), 'recursive' => 1));
        unset($lyrics['Stat']);
        unset($lyrics['User']);
        unset($lyrics['Album']);
        
        $url = 'http://'.$_SERVER['SERVER_NAME'].LinkHelper::toTrack($lyrics['Artist']['name'],$lyrics['Track']['name']);
        //pr($lyrics);
        $this->set(compact("lyrics", "url"));
    }
    
}
?>
