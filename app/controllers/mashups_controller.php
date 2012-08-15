<?php

class MashupsController extends AppController
{
    private $cacheTime='-7 days';
    
    private $lastfmkey=''; //create your last fm key in http://www.last.fm/api
    private $lastfmurl='http://ws.audioscrobbler.com/2.0/';
    
    var $layout = 'ajax';
    
    
    private function myhash ($s) { return sha1($s); }
    private function normalize($s) {
        App::import('Vendor', 'mystring');
        //$s = Inflector::slug(html_entity_decode($s));
        return normalize($s);
    }
    
    public function audio($artist,$track) {
        $cartist = $this->normalize($artist);
        $ctrack = $this->normalize($track);
    
        $artist=urlencode($artist);
        $track=urlencode($track);
        
        $page = 0;
        $max_files = 4;
        
        $url_search = "http://www.goear.com/search.php?q=%s+%s&p=%s";
        $url_xml = "http://www.goear.com/files/xmlfiles/%s/secm%s.xml"; //http://www.goear.com/files/xmlfiles/2/secm213c04d.xml
        
        $url_suggest = "http://www.google.com/search?q=$artist+$track+music+audio";
        $this->set('url_suggest',$url_suggest);
        
        $pattern_search = '/href="listen(\.php\?v=|\/)([^\/"]*?)"/s';
        $pattern_xml = '/path="(?P<path>.*?)"|artist="(?P<artist>.*?)"|title="(?P<title>.*?)"/s';
        
        
        $ids_goear = array(); // ID goear
        $audio_files = array();
        
        
        while ($page != -1) {
            $tmp = sprintf($url_search, $artist, $track, $page);
            //pr($tmp);
            $s = $this->geturl($tmp);
            //pr($s);
            
            if (!empty($s)) {
                //href="listen.php?v=3933376" class="escuchar"
               
                $out = array();
                $nresults = preg_match_all($pattern_search,$s,$out,PREG_PATTERN_ORDER);
                //pr($out);
                foreach($out[2] as $founded) {
                    array_push($ids_goear, $founded);
                }
            }
            
            //si queremos seguir parseando hasta el infinito
            $page = -1;
        }
        
        //foreach ($ids_goear as $id) {
        if ($nresults<$max_files) $max_files = $nresults;
        
        for($i=0; $i<$max_files; $i++) {
            $tmp = sprintf($url_xml, $ids_goear[$i][0], $ids_goear[$i]);
            //pr($tmp);
            $s = $this->geturl($tmp);
            
            if (!empty($s)) {
                //pr($s);
                /*$xml = new SimpleXMLElement($s);

                $file = array(
                    'path'=>(string)$xml->song[0]['path'],
                    'artist'=>(string)$xml->song[0]['artist'],
                    'track'=>(string)$xml->song[0]['title']);
                */
                $out = array();
                $t = preg_match_all($pattern_xml,$s,$out,PREG_PATTERN_ORDER);
                $file = array(
                    'url'=>$out['path'][0],
                    'artist'=>$out['artist'][1],
                    'track'=>$out['title'][2],
                    'goear_id'=>$ids_goear[$i]);

                $newartist = $this->normalize($file['artist']);
                $newtrack = $this->normalize($file['track']);
                
                $subartist = substr_count($newartist,$cartist);
                $subtrack = substr_count($newtrack,$ctrack);
                
                $levartist = levenshtein($newartist,$cartist); 
                $levtrack = levenshtein($newtrack,$ctrack);
                
                $ok=false;
                if($subartist>0 && $subtrack>0) {
                    $ok=true;
                } 
                else if ($levartist < 4 && $levtrack < 4) {
                    $ok=true;
                }
                
                
                if($ok) {
                    array_push($audio_files, $file);
                }
                else {
                    //aumentar el número de archivos xml a parsear si no encuentro la cancion
                    if ($nresults<$max_files) {
                        $max_files+=1;
                    }
                }
            }

        }
        
        //pr($ids_goear);
        //pr($audio_files);
        
        $this->set('audio_files', $audio_files);
        
    }
        
    public function videos($artist,$track)
    {
        //$this->layout = 'ajax';
        $cartist = $this->normalize($artist);
        $ctrack = $this->normalize($track);
        
        $artist=urlencode($artist);
        $track=urlencode($track);
        
        $keywords = explode('+', $artist.'+'.$track);
        
        $url_suggest = "http://www.google.com/search?q=$artist+$track+video";
        $this->set('url_suggest',$url_suggest);
        
        $max_videos = 6;
        
        //$image = 'http://img.youtube.com/vi/%s/2.jpg';
        
        
        $max = $max_videos;
        //$url = "http://gdata.youtube.com/feeds/api/videos?format=1&vq=$artist+$track&start-index=1&max-results=$max&orderby=relevance&alt=rss";
        
        //PROCESAR URL DANDOLE TOQUE SEMANTICO
        $base_url = "http://gdata.youtube.com/feeds/api/videos/-%s?max-results=$max&alt=rss&orderby=viewCount";
        $base_cat = urlencode("{http://gdata.youtube.com/schemas/2007/categories.cat}")."Music";
        $base_keywords = urlencode("{http://gdata.youtube.com/schemas/2007/keywords.cat}");
        
        $url_cat = "/". $base_cat;  
        $url_keywords="";
        foreach($keywords as $key) {
            $url_keywords .= "/". $base_keywords . $key;
        }
        $url = sprintf($base_url, $url_cat.$url_keywords);
        
        //echo $url;
        
        
        
        $s = $this->geturl($url);
        
        if (!empty($s))
        {
            $videos = array();
        
            $out = array();
            //$p = '/<a class="newvtitlelink" href="\/watch\?v=(.*?)"(.*?)VidHorz\'\);">(.*?)<\/a><br\/>/s';
            $p = '/<item>.*?<title>(.*?)<\/title>.*?<link>.*?v=(.*?)<\/link>/s';
            $nresults = preg_match_all($p,$s,$out,PREG_PATTERN_ORDER);
            //print_r($out);
        
            if ($nresults<$max_videos) $max_videos = $nresults;
            
            for ($i=0; $i<$max_videos; $i++)
            {
                $id = $out[2][$i];
                $title = strtr(strip_tags($out[1][$i]),'"',' ');
                //$preview = sprintf ($image,$out[2][$i]);
                
                //$videos[]=array('id'=>$id, 'title'=> $title, 'preview' => $preview );
                
                $videos[]=array('id'=>$id, 'title'=> $title);
                /* DESACTIVADO POR USAR MEJOR BUSQUEDA
                $new_title = $this->normalize($title);
                $subartist = substr_count($new_title,$cartist);
                $subtrack = substr_count($new_title,$ctrack);
                
                $ok=false;
                if($subartist>0 || $subtrack>0) {
                    $ok=true;
                } 
                //
                
                if ($ok) {
                    $videos[]=array('id'=>$id, 'title'=> $title);
                }
                else {
                    //aumentar el número de videos a agregar si creo que el video no tiene nada que ver
                    if ($nresults<$max_videos) {
                        $max_videos+=1;
                    }
                }
                */
            }
            
            //print_r($videos);
            $this->set('videos',$videos);
        }
        else
        {
            //error al obtener videos
            $this->set('error',true);
        }
    
    
         
    }
    
    public function imageartist($artist,$size='large') {
        $artist = Sanitize::escape($artist);
        $uartist = urlencode($artist);
        
        $this->set('artist',$artist);        
        
        $info = $this->getlastfm('artist.getInfo',"artist={$uartist}" );
        
        $p = '/<image size="'.$size.'">(.*?)<\/image>/s';
        $t = preg_match_all($p,$info,$out,PREG_PATTERN_ORDER);
        
        if ($t) {
            //print_r($out);
            $image = $out[1][0];
            $this->set('image', $image );
        }
        else {
            $this->set('image', false );
        }

    }
    
    public function imagealbum($artist,$album,$size='large') {
        $artist = Sanitize::escape($artist);
        $album = Sanitize::escape($album);
        
        $this->set('artist',$artist); 
        $this->set('album',$album); 
        
        $uartist = urlencode($artist);
        $ualbum = urlencode($album);
        
        $info = $this->getlastfm('album.getInfo',"artist={$uartist}&album={$ualbum}");
        
        $p = '/<image size="'.$size.'">(.*?)<\/image>/s';
        $t = preg_match_all($p,$info,$out,PREG_PATTERN_ORDER);

        if ($t) {
            //print_r($out);
            $image = $out[1][0];
            $this->set('image', $image );
        }
        else {
            $this->set('image', false );
        }

    }
    
    
    private function getlastfm($method, $param) {
        $query = "method=$method&$param";
        
        $url = $this->lastfmurl.'?api_key='.$this->lastfmkey.'&'.$query;
        //echo $url;
        $out = $this->geturl($url);
        
        return $out;
    }
    
    
    private function geturl($url,$nocached=false)
    {
        $hash = $this->myhash($url);

        if ($this->Mashup->isok($hash,date("r",strtotime($this->cacheTime))) && $nocached==false)
        {
            $s = $this->Mashup->read($hash);
        }
        else
        {
            /* forma antes de godaddy
            * $s = file_get_contents($url);
            */

            /* despues de godaddy
            */

            $ch = curl_init();
            // Se establece la URL y algunas opciones
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
            // Se obtiene la URL indicada
            $t = curl_exec($ch);
            // Se cierra el recurso CURL y se liberan los recursos del sistema
            curl_close($ch);

            $s = $t;

            $l = strlen($s);
            if ($s!==FALSE) 
            {
                $this->Mashup->write($url,$hash,$s);
            }
        }

        return $s;
    }
    

}

?>
