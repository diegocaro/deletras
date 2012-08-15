<?php

class User extends AppModel
{
    var $hasMany = array('Track','Lyric');
    var $belongsTo = 'Group';
    var $recursive = -1;
    
	var $validate = array(
	       'name' => array(
		       'rule' => array('minlength', 5),
		       'allowEmpty' => true,
			   'message' => "Debes escribir un nombre real"
			   ),

	       'username' => array(
	            'notempty',
                'alphanumeric' => array(
		           'rule' => array('alphanumeric'),
			       'message' => 'Asegúrate que solo sean letras y números'
			     ),
 				'between' => array(
					'rule' => array('between', 5, 30),
					'message' => 'Tu nombre de usuario debe tener entre 5 y 30 carácteres'
					),
		        'unique' => array(
                    'rule' => 'isUnique',
                    'message' => 'Este usuario ya existe.'
		        )
			   ),
	       'email' => array(
	            'isemail' => array(
		            'rule' => array('email', 'email' ),
		            'allowEmpty' => true,
				    'message' => 'Asegúrate que sea una dirección de correo válida.'
				   ),
 		         'unique' => array(
                    'rule' => 'isUnique',
                    'message' => 'Este email ya está registrado.'
		          )
				),
           'passwd' => array('notempty'),
           'new_passwd' => array(             
		       'equalTo' => array(
			       'rule' => array('equalTo', 'confirm_passwd' ),
				   'message' => 'Por favor, escribe la misma contraseña.'
				   ),
				'between' => array(
					'rule' => array('between', 5, 10),
					'allowEmpty' => true,
					'message' => 'Tu contraseña debe tener entre 5 y 10 carácteres.'
					)
				)
        );
        
    function beforeSave(){
	    $this->setNewPassword();
	    //$this->setEmailHash();
	    
	    if (empty($this->data['User']['name'])) {
	        unset($this->data['User']['name']);
        }
        if (empty($this->data['User']['email'])) {
            unset($this->data['User']['email']);
        }
	    
	    
		return true;
	}
	
	/* No usado ya.
	function setEmailHash() {
	    App::import('Vendor', 'facebook/lib');
	    if( !empty($this->data['User']['email']) ) {
	        $this->data['User']['email_hash'] = facebook_hashemail($this->data['User']['email']);
	    }
	}
	*/
	
	/**
	 * sets the password to be equal to the verified value from the temporary password field
	 *
	 * Under AuthComponent, any time a form is submitted with a field name that matches the 
	 * expected password field, it is hashed before any other operation can be done.  This 
	 * prevents the equalTo() rule check from working, so we take the password in a form input
	 * named something else.  Then after verification, but before saving the record, we pass
	 * the hashed value to the correct password field.
	 *
	 * @return boolean TRUE
	 */
	function setNewPassword()
	{
	    if( !empty( $this->data['User']['new_passwd_hash'] ) ){
		    $this->data['User']['passwd'] = $this->data['User']['new_passwd_hash'];
		}
		return TRUE;
	}
	
    /**
	 * Overrides core equalTo() to verify that two form fields are equal
	 *
	 * @param array $field contains the name of the primary field and the value of that field
	 * @param string $compare_field contains the name of the field to compare the primary field to
	 * @access public
	 * @return boolean FALSE if the fields do not match TRUE if they do
	 */
	function equalTo( $field=array(), $compare_field=null ) 
	{
		foreach( $field as $key => $value ){
			$v1 = $value;
			$v2 = $this->data[$this->name][ $compare_field ];
            if($v1 !== $v2) {
			    return FALSE;
		    } else {
		       continue;
		    }
		}
		return TRUE;

    }
}

?>
