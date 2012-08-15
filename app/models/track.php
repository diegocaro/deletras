<?php

class Track extends AppModel
{
    var $belongsTo = array('Ip','Artist','User');
    var $hasAndBelongsToMany = array('Album');
    var $hasMany = array('Lyric' => array('order' => 'created DESC'),'Stat','Comment');
    
    var $validate = array(
                'name' => VALID_NOT_EMPTY,
                'code' => VALID_NOT_EMPTY
                );
    
    var $order = 'Track.code ASC';
     
    function beforeSave() {
        LinkHelper::formatName('Track', &$this->data);        
        return true;
    }
    
    function insert(&$data)
    {
        LinkHelper::formatName('Track', &$data);
        
        $id = $this->field ('id',"Track.code='". $data['Track']['code']."' AND Track.artist_id='{$data['Track']['artist_id']}'",0 );

        /* Código indocumentado. Al parecer, permite la actualización de datos?
        $data['Track']['id'] = $id;
        if ($this->save ( $data ))
        {
            //antes de guardar, carga info por defecto, no sé bien por qué
            $this->create();
            
            if (empty($id)) 
            { 
                $id = $this->getLastInsertId(); 
            }
        }
        else
        {
            return false;
        }
        */
        
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
        
        $data['Track']['id'] = $id;
        return true;
    }
}

?>
