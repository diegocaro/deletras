<?php

class Album extends AppModel
{
    var $belongsTo = array('Artist');
    var $hasAndBelongsToMany = array('Track');
    
    var $validate = array(
                    'name' => VALID_NOT_EMPTY,
                'code' => VALID_NOT_EMPTY
                    );

    var $order = 'Album.code ASC';
    
    function beforeSave() {
        LinkHelper::formatName('Album', &$this->data);   
        return true;
    }  
      
    function insert(&$data)
    {
        LinkHelper::formatName('Album', &$data);   
        
        $id = $this->field ('id',"Album.code='". $data['Album']['code']."' AND Album.artist_id='{$data['Album']['artist_id']}'",0 );
        
        if (empty($id))
        {
            //antes de guardar, carga info por defecto, no sé bien por qué
            $this->create();
            
            if ( $this->save ( $data ) )
            {
                $id = $this->getLastInsertId();
            }
            else
                return false;
        }
        
        $data['Album']['id'] = $id;
        
        return true;
    }
}

?>
