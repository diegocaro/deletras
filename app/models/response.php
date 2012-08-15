<?php
class Response extends AppModel {

	var $name = 'Response';
	var $validate = array(
		'content' => array('notempty'),
		'request_id' => array('numeric'),
		'user_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)/*,
			'Request' => array('className' => 'Request',
								'foreignKey' => 'request_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)*/
	);

    function afterSave($created) {
        if ($created) {
            $response_count = $this->find('count', 
                array('conditions' => 
                    array('request_id' => $this->data['Response']['request_id'])
                ) 
            );
            
            App::import('Model','Request');
            $request = new Request;
            $result = $request->update($this->data['Response']['request_id'], $response_count, $this->data['Response']['created']);
                       
            /**
             * Sendmail con respuesta nueva
             */
            //ClassRegistry::init('RequestsController','Controller')->
            App::import('Controller','Requests');
            RequestsController::_sendmail($this->data['Response']);
            
            return $result;
        }
        return true;
    }
    
    
    
    
}
?>
