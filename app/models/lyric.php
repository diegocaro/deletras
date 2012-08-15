<?php

class Lyric extends AppModel
{
    var $belongsTo = array('Track','User','Ip');

    var $validate = array(
                'text' => VALID_NOT_EMPTY
                );
    
    function beforeSave() {
        if (empty($this->data['Track']['code'])) {
            $this->data['Lyric']['hash']=LinkHelper::toHash($this->data['Lyric']['text']);
        }
        
        return true;
    }
    
    function insert(&$data)
    {
        $data['Lyric']['hash']=LinkHelper::toHash($data['Lyric']['text']);
        
        $id = $this->field ('id',"track_id='{$data['Lyric']['track_id']}' AND hash='".$data['Lyric']['hash']."'",0 );

        if (empty($id))
        {
            //antes de guardar, carga info por defecto, no sé bien por qué
            $this->create();
            
            if( $this->save ( $data ) )
            {
                //ok! insertado
            }
            else
            {
                return false;
            }
        }
        
        return true;
    }
    
    
    
    function TopContributors ($desde, $hasta, $n=10) {
        $ret = $this->query("SELECT User.name, User.username, T.count
                FROM 
                (
                    SELECT count(Lyric.user_id) AS count, Lyric.user_id
                    FROM lyrics AS Lyric
                    WHERE 
                      Lyric.created>='$desde' AND 
                      Lyric.created <='$hasta'
                    GROUP BY Lyric.user_id
                ) AS T 
                LEFT JOIN users AS User ON (T.user_id = User.id)
                ORDER BY count DESC
                LIMIT $n");

        return $ret;
    
    
    }
}

?>
