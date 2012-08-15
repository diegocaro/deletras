<?php
//AppModel gives you all of Cake's Model functionality
class Migrate extends AppModel
{
    // Its always good practice to include this variable.
    public $name      = 'Migrate';
    
    public $validate = array(
      'user_id' => VALID_NOT_EMPTY,
      'random' => VALID_NOT_EMPTY
   );
}

?>
