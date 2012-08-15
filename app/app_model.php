<?php

class AppModel extends Model
{
//    var $recursive=1; por defecto

    function unbindAll($params = array())
    {
        foreach($this->__associations as $ass)
        {
            if(!empty($this->{$ass}))
            {
                 $this->__backAssociation[$ass] = $this->{$ass};
                if(isset($params[$ass]))
                {
                    foreach($this->{$ass} as $model => $detail)
                    {
                        if(!in_array($model,$params[$ass]))
                        {
                             $this->__backAssociation = array_merge($this->__backAssociation, $this->{$ass});
                            unset($this->{$ass}[$model]);
                        }
                    }
                }else
                {
                    $this->__backAssociation = array_merge($this->__backAssociation, $this->{$ass});
                    $this->{$ass} = array();
                }
                
            }
        }
        return true;
    }   
}

?>
