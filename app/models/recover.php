<?php
//AppModel gives you all of Cake's Model functionality
class Recover extends AppModel
{
    // Its always good practice to include this variable.
    public $name      = 'Recover';
    
    public $validate = array(
      'user_id' => VALID_NOT_EMPTY,
      'random' => VALID_NOT_EMPTY
   );
}

?>
