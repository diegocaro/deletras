<?php 
uses('model'.DS.'model');

App::import('Sanitize');
App::import('Core','Helper');
App::import('Helper','Link');

class MigrateShell extends Shell {
    var $times = array();
    var $uses = array('User','Deletras','Lyric','Track','Album','Artist');
  
    function initialize() {
        $this->times['start'] = microtime(true);
        parent::initialize();
    }
    
    function finalize() {
        $this->times['end'] = microtime(true);
        $duration = round($this->times['end'] - $this->times['start'], 2);
        $this->hr();
        $this->out('Migration took '.$duration.' seconds.');

    }


    function main() {
        $users = array();
        $allusers = $this->User->find('all', array('recursive'=>-1, 'fields'=>array('User.username','User.id')));
        foreach ($allusers as $user) {
            $users[$user['User']['username']] = $user['User']['id'];
        }
        
        $i = 1;
        $old_songs = $this->Deletras->query('
        SELECT artist as name,album as name,song as name,lyric as text, user as username 
        FROM bita_song AS Track 
            left join bita_artist AS Artist using (id_artist) 
            left join bita_album AS Album using (id_album) 
            left join bita_lyric AS Lyric using (id_song) 
            left join bita_user AS User using (id_user)
            ORDER BY Lyric.id_lyric ASC ');
        
        foreach ($old_songs as $var) {
            $this->hr();
            $this->out('Process '.$i++.'/'.count($old_songs));
        
            $error = false;
            //print_r($var);
            $data = $var;
            
            $data['Ip']['ip'] = '127.0.0.1';
            
            if (empty($users[$var['User']['username']])) {
                $data['User']['id'] = 1;
            }
            else {
                $data['User']['id'] = $users[$var['User']['username']];
            }

            $data['Artist']['name'] = html_entity_decode(utf8_decode($data['Artist']['name']));
            $data['Album']['name'] = html_entity_decode(utf8_decode($data['Album']['name']));
            $data['Track']['name'] = html_entity_decode(utf8_decode($data['Track']['name']));
            $data['Lyric']['text'] = html_entity_decode(utf8_decode($data['Lyric']['text']));

            // BEGIN INSERTAR ARTISTA
            if (!$this->Artist->insert($data))
            {
                $error=true;
                $this->out('Error al insertar artista '. $data['Artist']['name']);
            }
            // END INSERTAR ARTISTA


            // BEGIN INSERTAR ALBUM
            if (! empty ($data['Album']['name']) )
            {
              $data['Album'] = array (
                             'name' => $data['Album']['name'],
                             'artist_id' => $data['Artist']['id']
                            );
                            
               if (!$this->Album->insert($data))
               {
                $error=true;
                $this->out('Error al insertar album '. $data['Album']['name']);
               }
            }
            // END INSERTAR ALBUM


            // BEGIN INSERTAR IP
            if (!$this->Lyric->Ip->insert($data))
            {
                $error = true;
                $this->out('Error al insertar ip '. $data['Ip']['name']);
            }
            // END INSERTAR IP
            
            
            // BEGIN INSERTAR TRACK
            $data['Track'] = array (
                              'name' => $data['Track']['name'],
                             'artist_id' => $data['Artist']['id'],
                             'user_id' => $data['User']['id'],
                             'ip_id' => $data['Ip']['id']
                            );
            if (! empty ($data['Album']['name']) )
            {
                $data['Album'] = array (
                             'Album' => array($data['Album']['id'])
                            );
            }
            
            if(!$this->Track->insert($data))
            {
                $error = true;
                $this->out('Error al insertar track '. $data['Track']['name']);
            }
            // END INSERTAR TRACK

            // INSERTAR LYRIC
            if (!$error)
            {
                $data['Lyric'] = array (
                               'text' => $data['Lyric']['text'],
                               'user_id' => $data['User']['id'],
                               'track_id' => $data['Track']['id'],
                               'ip_id' => $data['Ip']['id']
                              );
                              
                //$this->Lyric->create();
                //$this->Lyric = new Lyric;
                 
                if ( ! $this->Lyric->insert ( $data ) ) {
                    $error = true;
                    $this->out('Error al ingresar Lyric');
                    print_r($data);
                }
            }

            if ($error) { 
                print_r($var);
            } 
        
        }
        

        
        
                
        
        
    
        $this->finalize();
    }
    
    
    
    function users() {
        $data = array();
    
        $old_users = $this->Deletras->query('SELECT user AS username, email, web FROM bita_user AS User');
        foreach ($old_users as $user) {
            $data['User'] = $user['User'];
            $data['User']['passwd'] = 'migrado';
            $data['User']['active'] = 1;
            $data['User']['group_id'] = 1;
            $data['User']['created'] = date('c');
            
            $this->User->create($data['User']);
            
            if (!$this->User->save($data['User']))
            {
                $this->out('Error en usuario: ' . $user['User']['username']);
            } 
            
        }
    
    }

}




class Deletras extends Model {
    var $useDbConfig = 'deletras';
    var $useTable = false;
}

?>
