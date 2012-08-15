<?php
class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Html', 'Form', 'Ajax', 'Text', 'Time');
    var $components = array('RequestHandler');
    var $paginate = array(
        'Comment' => array('limit' => 10, 'order' => 'Comment.modified DESC')
        );
	/*
	function index() {
		$this->Comment->recursive = 0;
		$this->set('comments', $this->paginate());
	}
	*/

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Comment.', true));
			$this->redirect(array('action'=>'index'));
		}
		//$this->set('comment', $this->Comment->read(null, $id));
		$this->set('comments', $this->paginate('Comment', array('Comment.track_id = ' => $id)));
		$this->set('track_id', $id);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Comment->create();
			$this->data['Comment']['user_id'] = $this->othAuth->user('id');
			if ($this->Comment->save($this->data)) {
				//$this->Session->setFlash(__('The Comment has been saved', true));
				$this->set('saved', true);
			} else {
				//$this->Session->setFlash(__('The Comment could not be saved. Please, try again.', true));
			}
		}
		//$users = $this->Comment->User->find('list');
		//$tracks = $this->Comment->Track->find('list');
		//$this->set(compact('users', 'tracks'));
	}

/*
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Comment', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash(__('The Comment has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Comment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Comment->read(null, $id);
		}
		$users = $this->Comment->User->find('list');
		$tracks = $this->Comment->Track->find('list');
		$this->set(compact('users','tracks'));
	}
*/
	function delete($id = null) {
	
		$data = $this->Comment->read(null, $id);
		if ($data['Comment']['user_id'] != $this->othAuth->user('id')) {
		    $this->Session->setFlash(__('Invalid id for Comment', true));
			//$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Comment->del($id)) {
			$this->Session->setFlash(__('Comment deleted', true));
			//$this->redirect(array('action'=>'index'));
			
			//$this->redirect(array('controller'=>'requests', 
			//	                        'action'=>'view', 
			//	                        $this->data['Response']['request_id']));
		}

	}

}
?>
