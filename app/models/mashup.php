<?php

class Mashup extends AppModel
{
    var $primaryKey = 'hash'; 
    
    function isok($hash,$time)
    {
        $tmp = $this->findCount("hash='{$hash}' AND timestamp < '{$time}'");

        if ($tmp>0) return true;
        else false;
    }
    
    function write($url,$hash,$data)
    {
        $tmp = array('Mashup' => 
                array('url' => $url,
                      'hash' => $hash,
                      'data' => $data) );
        
        $this->save($tmp);
    }
    
    function read($hash)
    {
        $tmp = $this->field('data', "hash='{$hash}'");
        return $tmp;
    }
}

?>
