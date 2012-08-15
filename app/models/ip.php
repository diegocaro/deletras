<?php

class Ip extends AppModel
{
    var $hasMany = array('Track','Lyric');
    var $displayField = 'ip';
    
    var $validate = array(
                'ip' => VALID_NOT_EMPTY
                );
    
    
    function insert(&$data)
    {
        $id = $this->field ('id',"ip='". $data['Ip']['ip']."'",0 );
        
        if (empty($id))
        {
            if ( $this->save ( $data ) )
            {
                $id = $this->getLastInsertId();
            }
            else
                return false;
        }
        
        $data['Ip']['id'] = $id;
    
        return true;
    }
    

}

?>
