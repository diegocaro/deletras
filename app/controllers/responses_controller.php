<?php
class ResponsesController extends AppController {

	var $name = 'Responses';
	var $helpers = array('Html', 'Form', 'Time', 'Ajax');
	
	var $components = array('RequestHandler');
	
	function add() {
		if (!empty($this->data)) {
			$this->Response->create();
			
			$this->data['Response']['user_id'] = $this->othAuth->user('id');
			
			if ($this->Response->save($this->data)) {
				/**
				 * $this->flash(__('Response saved.', true), array(
				 *                   'controller'=>'requests', 
				 *                   'action'=>'view', 
				 *                   $this->data['Response']['request_id']));
				 */
                $this->set('response_saved', true);
                $this->data['Response']['content'] = '';
                /*$this->redirect(array('controller'=>'requests', 
				                        'action'=>'view', 
				                        $this->data['Response']['request_id']));*/
			} else {
			}
		}
		
		
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Response', true), array('action'=>'index'));
		}
	
		$data = $this->Response->read(null, $id);
		
		if ($data['Response']['user_id'] != $this->othAuth->user('id')) {
		    $this->flash(__('Invalid Response', true), array('action'=>'index'));
		}
		
		if (!empty($this->data)) {
		    $this->data['Response']['user_id'] = $this->othAuth->user('id');
			if ($this->Response->save($this->data)) {
				/**
				 * $this->flash(__('Response saved.', true), array(
				 *                   'controller'=>'requests', 
				 *                   'action'=>'view', 
				 *                   $this->data['Response']['request_id']));
				 */
				                    
                $this->redirect(array('controller'=>'requests', 
				                        'action'=>'view', 
				                        $this->data['Response']['request_id']));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $data;
		}

	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Response', true), array('action'=>'index'));
		}
		
		$data = $this->Response->read(null, $id);
		if ($data['Response']['user_id'] != $this->othAuth->user('id')) {
		    $this->flash(__('Invalid Response', true), array('action'=>'index'));
		}
		
		if ($this->Response->del($id)) {
			/*$this->flash(__('Response deleted', true), array('action'=>'index'));*/
			
			$this->redirect(array('controller'=>'requests', 
				                        'action'=>'view', 
				                        $this->data['Response']['request_id']));
		}
	}

}
?>
