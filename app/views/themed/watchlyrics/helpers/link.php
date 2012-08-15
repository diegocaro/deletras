<?php

App::import('Vendor', 'mystring');

App::import('Core', 'Inflector');

class LinkHelper extends Helper
{
  //var $helpers = array('Html');
    public static $codes = array();
    public static $codescut = array();
    
    function makeTrack($artist,$track)
    {
        return $this->output('<a href="'.$this->webroot.'music/'.$this->toCode($artist).
                             '/_/'.$this->toCode($track).'">'.
                             myhtmlentities($track).'</a>');
    }
    
    function toTrack($artist,$track) {
        $str = '/music/'.self::toCode($artist).
                             '/_/'.self::toCode($track);
        return $str;
    }
    
    function makeEdit($artist,$track,$msg='editar')
    {
        return $this->output('<a href="'.$this->webroot.'music/'.$this->toCode($artist).
                             '/_/'.$this->toCode($track).'/+edit">'.
                             $msg.'</a>');
    }
    
    function makeAlbum($artist,$album,$year='')
    {
      if (!empty($year)) $year = " <strong>(".myhtmlentities($year).")</strong>";
      else $year = '';
      
        return $this->output('<a href="'.$this->webroot.'music/'.$this->toCode($artist).
                              '/'.$this->toCode($album).'">'.
                             myhtmlentities($album).$year.'</a>');
    }
    
    function makeArtist($artist)
    {
        return $this->output('<a href="'.$this->webroot.'music/'.$this->toCode($artist).
                              '">'.myhtmlentities($artist).'</a>');
    }
    
    function makeUser($user, $text = null)
    {
        if ($text==null) $text = $user;
        
        return $this->output('<a href="'.$this->webroot.'user/'.$this->toCode($user).
                              '">'.myhtmlentities($text).'</a>');
    }
    
    function tohtml($str) {
        return myhtmlentities($str);
    }
    
    function tourl($str) {
        return myurlencode($str);
    }
    
    function toArtist($str) {
        return self::toCode($str,true);
    }
    
    function toCode($str,$cut=false) {
        if ( array_key_exists($str,self::$codes) && !$cut) {
            return self::$codes[$str];
        }
        else if ( array_key_exists($str,self::$codescut) && $cut) {
            return self::$codescut[$str];
        }        
        else {
            $code = mycode($str,'-',$cut);
            
            if (!$cut) {
                self::$codes[$str] = $code;
            }
            else if ($cut) {
                self::$codescut[$str] = $code;
            }
            return $code;
        }
    }
    
    function toHash($str) {
        return sha1($str);
    }
    
    
    
    function formatName($model, &$data) {
        //$cut es para cortar los artículos en los nombres de artista
        if ($model == 'Artist') {
            $cutart = true;
        }
        else  {
            $cutart = false;
        }
        
        $data[$model]['name'] = trim ($data[$model]['name']);
        $data[$model]['name'] = ucwords(strtolower ($data[$model]['name']));
        $data[$model]['code'] = self::toCode($data[$model]['name'],$cutart);
    }
}

?>
