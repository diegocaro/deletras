<?php

class Artist extends AppModel
{
    var $hasMany = array('Album'=> 
                        array('order' => 'Album.date ASC, Album.code ASC')
                   ,'Track' => 
                        array('order'=>'Track.code ASC')
                   );
    
    var $validate = array(
                'name' => VALID_NOT_EMPTY,
                'code' => VALID_NOT_EMPTY
                //'name' => '|[^\/]{2,}$|i'
                );
                
    var $order = 'Artist.code ASC';
    
    function beforeSave() {
        LinkHelper::formatName('Artist', &$this->data);
        
        return true;
    }
    
    function insert(&$data) {
        LinkHelper::formatName('Artist', &$data);
        
        $id = $this->field ('id',"code='". $data['Artist']['code']."'",0 );
        
        if (empty($id))
        {
            //antes de guardar, carga info por defecto, no sé bien por qué
            $this->create();
            
            if ( $this->save ( $data ) )
            {
                $id = $this->getLastInsertId();
            }
            else
            {
                return false;
            }            
        }
        
        $data['Artist']['id'] = $id;
        
        return true;
    }
}

?>
