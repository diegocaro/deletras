

<?php
if (!$othAuth->sessionValid())  {
    //echo "<p>Regístrate para responder!</p>";
}

if (empty($request_id)) {
    $request_id = $request['Request']['id'];
}

if ($suscripted == 1) {
    $newsuscripted = 0;
    $checked = 'checked';
}
else {
    $newsuscripted = 1;
    $checked = '';
}

$remoteFunction = $ajax->remoteFunction( 
    array( 
    'url' => array( 'controller' => 'requests', 'action' => 'suscripted', $request_id, $newsuscripted ),
    'update' => 'RequestsSuscripted' ) 
); 
    
?>


<div class="requests-suscripted">	
	<?php

	
		echo $form->input('RequestsUser.suscripted', array('type'=>'checkbox','checked'=>$checked,'onclick'=>$remoteFunction,'label' => 'Enviarme un email cuando esta solicitud sea respondida') );
	?>


</div>
