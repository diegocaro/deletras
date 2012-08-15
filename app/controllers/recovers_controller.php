<?php
/**
*  Chipotle Software
*  Manuel Montoya 2002-2007 
*  GPL manuel<at>mononeurona<dot>org
*/ 
 
uses('sanitize');

class RecoversController extends AppController
{  
   public $helpers       = array('Javascript', 'Ajax', 'Form');
   var $uses = array('Recover','User');

   public function newpwd($random = null)
   {
      $this->pageTitle = 'Recuperar contraseña';
     
      if ( $random == null )
      {  
        redirect('/');
      }
      
      //$this->layout = 'popup';
      
      //$this->pageTitle = 'Centauro New Password';
      
      //$conditions = array("random" => $random);
      
      //$fields     = array("id", "user_id");
      
      $row = $this->Recover->find("random = '$random'", array("id", "user_id"));
      
      if ( $row == null )
      {
          $this->redirect('/');
      } 
      else
      {
         
         $this->data["User"]["id"]     = $row["Recover"]["user_id"];
         $pwd                          = $this->genPwd(8);
         $this->data["User"]["passwd"] = $this->othAuth->_getHashOf($pwd);
         
         //$this->User = new User;
         
         
         if ( $this->User->save($this->data["User"]) )
         {
         
         
              $this->set('username', $this->User->field('username',"id={$this->data['User']['id']}") );
              $this->set('pwd', $pwd);
              
              $this->Recover->del($row["Recover"]["id"]);  //del the row
         }
      }
   }
   
    
       private function genPwd($length) 
       {
        
        srand((double)microtime()*1000000); 
        
        $vowels = array("a", "e", "i", "o", "u"); 
        $cons = array("b", "c", "d", "g", "h", "j", "k", "l", "m", "n", "p", "r", "s", "t", "u", "v", "w", "tr", 
        "cr", "br", "fr", "th", "dr", "ch", "ph", "wr", "st", "sp", "sw", "pr", "sl", "cl"); 
         
        $num_vowels = count($vowels); 
        $num_cons   = count($cons); 
        
         $password = '';
        
        for($i = 0; $i < $length; $i++)
        { 
            $password .= $cons[rand(0, $num_cons - 1)] . $vowels[rand(0, $num_vowels - 1)]; 
        } 
         
        return substr($password, 0, $length); 
     }
     
/*     
     public function _genPassword($length) {
    
        $password = '';
        
        srand((double)microtime()*1000000);
        
        $vowels  = array("a", "e", "i", "o", "u");
        $numbers = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
        $cons    = array("b", "c", "d", "g", "h", "j", "k", "l", "m", "n", "p", "r", "s", "t", "u", "v", "w", "tr", 
        "cr", "br", "fr", "th", "dr", "ch", "ph", "wr", "st", "sp", "sw", "pr", "sl", "cl"); 
         
        $num_vowels = count($vowels); 
        $num_cons   = count($cons); 
        
         
        for($i = 0; $i < $length; $i++)
        {
            $password .= $cons[rand(0, $num_cons - 1)] . $numbers[rand(0, count($numbers) - 1)] . $vowels[rand(0, $num_vowels - 1)]; 
        }
        
        return substr($password, 0, $length); 
    }
    */
}
?>
