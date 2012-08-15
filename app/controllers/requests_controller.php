<?php
class RequestsController extends AppController {

	var $name = 'Requests';
	var $helpers = array('Html', 'Form', 'Time', 'Text', 'Ajax');
    var $paginate = array(
            'Request' => array('limit' => 10, 'order' => 'Request.response_updated DESC'),
            'Response' => array('limit' => 10, 'order' => 'Response.created ASC', 'page' => 'last') 
            );
    
    var $components = array('RequestHandler');
    
    var $pageTitle = 'Solicitudes';
    
	function index() {
		$this->Request->recursive = 0;
		$this->set('requests', $this->paginate());
		
		if ($this->params['isAjax']) { $this->render('index_ajax'); }
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Request', true), array('action'=>'index'));
		}
		$this->Request->recursive = 0;

		$request = $this->Request->read(null, $id);
		$this->set('request', $request);
		$this->set('responses', $this->paginate('Response', array('Response.request_id = ' => $id)));
		
		if ($this->othAuth->sessionValid() ) {
		    $suscripted = $this->Request->RequestsUser->field('RequestsUser.suscripted', 
                    array('RequestsUser.request_id' => $id, 
                          'RequestsUser.user_id' => $this->othAuth->user('id')
                      )
                   );

            $this->set('suscripted', $suscripted);
		}
		
		$this->pageTitle = 'Solicitud: '. $request['Request']['title'];
	
		if ($this->params['isAjax']) { $this->render('view_responses_ajax'); }
	}

	function add() {
		if (!empty($this->data)) {
			$this->Request->create();
			
			$this->data['Request']['user_id'] = $this->othAuth->user('id');

			if ($this->Request->save($this->data)) {
				//$this->flash(__('Request saved.', true), array('action'=>'view', $this->Request->id));
				$this->redirect(array('action'=>'view', $this->Request->id));
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Request', true), array('action'=>'index'));
		}
		
		$data = $this->Request->read(null, $id);
		
		if ($data['Request']['user_id'] != $this->othAuth->user('id')) {
		    $this->flash(__('Invalid Request', true), array('action'=>'index'));
		}
		
		if (!empty($this->data)) {
		    $this->data['Request']['user_id'] = $this->othAuth->user('id');
			if ($this->Request->save($this->data)) {
				//$this->flash(__('The Request has been saved.', true), array('action'=>'index'));
				$this->redirect(array('action'=>'view', $this->Request->id));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $data;
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Request', true), array('action'=>'index'));
		}
		
		$data = $this->Request->read(null, $id);
		if ($data['Request']['user_id'] != $this->othAuth->user('id')) {
		    $this->flash(__('Invalid Request', true), array('action'=>'index'));
		}
		
		if ($this->Request->del($id)) {
			$this->flash(__('Request deleted', true), array('action'=>'index'));
		}
	}
	
	
	function _sendmail($response) {
        $request_title = ClassRegistry::init('Request')->field('Request.title', array('Request.id' => $response['request_id']) ) ;
        
        $response_username = ClassRegistry::init('User')->field('User.username', array('User.id' => $response['user_id']) ) ;
        
        $this->RequestsUser = ClassRegistry::init('RequestsUser');
        $this->RequestsUser->bindModel(array('belongsTo' => array('User') ) );
        $users = $this->RequestsUser->find('all', array('conditions' => array('RequestsUser.request_id' => $response['request_id'], 'RequestsUser.suscripted' => '1', 'RequestsUser.user_id <>' => $response['user_id']) ) );
        
        
        App::import('Component', 'Email');
        $this->Email = new EmailComponent;
        
        $this->Email->subject   = 'deLetras.cl - Han enviado una nueva respuesta a la solicitud: '. $request_title .'.' ;
        //$this->Email->replyTo   = 'noreply@mononeurona.org';
        $this->Email->sendAs    = 'html';
        //$this->Email->template  = null;
        $this->Email->from      = 'noreply@deletras.cl';
        $this->Email->lineLength = 120;

        
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/requests/view/'.$response['request_id'];
        
        $msg  = "Estás recibiendo este mensaje porque estás suscrito a la solicitud: <strong>". $request_title . "</strong> \n<br />";
        $msg .= "Nueva respuesta por <strong>". $response_username . "</strong>:\n";
        $msg .= "<blockquoute>". $response['content']."</blockquote>";
        
        $msg .= "\n<br />".'Para responder visita <a href="'. "\n".$url .'">'.$url .'</a>';

        $msg .= "\n\n<br /><br />Atte. el equipo deLetras<br />\nhttp://".$_SERVER['SERVER_NAME'];
        
        foreach($users as $user) {
            if (!empty($user['User']['email']))
            {
                $this->Email->to = $user['User']['email'];
                //pr($this->Email->to);
                $this->Email->send($msg);
            }
        }

	
	}
	
	
	function suscripted($request_id, $value) {
		if (!$request_id && !$value) {
			$this->flash(__('Invalid Request', true), array('action'=>'index'));
		}
		
		$suscripted = $this->Request->RequestsUser->find('first', 
	        array('conditions' => 
                array('RequestsUser.request_id' => $request_id, 
                      'RequestsUser.user_id' => $this->othAuth->user('id')
                  )
              ) );
        
        if (empty($suscripted)) {
            $suscripted = array('RequestsUser' =>
                array('request_id' => $request_id, 
                      'user_id' => $this->othAuth->user('id'),
                      'suscripted' => $value
                  )
              );
        }
        else {
            $suscripted['RequestsUser']['suscripted'] = $value;
        }
        
        $this->Request->RequestsUser->save($suscripted);
		
		$this->set('suscripted', $value);
		$this->set('request_id', $request_id);
		
		$this->layout = 'ajax';
	}
	
}
?>
