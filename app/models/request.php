<?php
class Request extends AppModel {

	var $name = 'Request';
	var $validate = array(
		'title' => array('notempty'),
		'content' => array('notempty'),
		'user_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasMany = array(
			'Response' => array('className' => 'Response',
								'foreignKey' => 'request_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => 'created ASC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);
    
    var $hasAndBelongsToMany = array(
            'Users' => array(
                'className' => 'Users'
            )
    );
    // Actializar fecha de ultima respuesta y contador de respuestas
    function update($id, $response_count, $response_updated) {
        $data = array('Request');
        
        $data['Request']['id'] = $id;
        $data['Request']['response_count'] = $response_count; 
        $data['Request']['response_updated'] = $response_updated;
        
        return $this->save($data);
    }
    
    function beforeSave() {
        // Fecha de actualización
        if (isset($this->data['Request']['created']) && !empty($this->data['Request']['created'])) {
            $this->data['Request'] += array('response_updated' => $this->data['Request']['created']);
        }
        
        // Sanitizar titulo
        if (isset($this->data['Request']['title']) ) {
            $this->data['Request']['title'] = Sanitize::html( $this->data['Request']['title'], true);
        }
      
        return true;
    }
    
    function afterSave() {
        if (isset($this->data['RequestsUser']['suscripted'])) {
            // Ver si fue suscrito
            $data['RequestsUser']['request_id'] = $this->id;
            $data['RequestsUser']['user_id'] = $this->data['Request']['user_id'];
            $data['RequestsUser']['suscripted'] = $this->data['RequestsUser']['suscripted'];
            $this->RequestsUser->save($data);
        }
    
    }

}
?>
