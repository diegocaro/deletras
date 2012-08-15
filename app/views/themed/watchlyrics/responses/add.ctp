<div class="responses-add form">

<h2>Responde!</h2>

<?php
if (!$othAuth->sessionValid())  {
    //echo "<p>Regístrate para responder!</p>";
}

?>
<?php
    echo $ajax->form('add', 'post', array(
        'model'    => 'Response',
        'url'      => array('controller' => 'responses', 'action' => 'add'),
        'update'   => 'ResponsesAdd'
    ));
    
    if (isset($response_saved) && $response_saved) {
        // Actualizar paginación
        $ResponsesView = $ajax->remoteFunction(array('url' => array('controller'=>'requests', 'action'=>'view', $this->data['Response']['request_id'], 'page:last'), 'update' => 'ResponsesIndex'));
        echo $javascript->codeBlock($ResponsesView);
    }
?>


	
	<?php
	    if (isset($request['Request']['id'])) echo $form->hidden('request_id', array('value' => $request['Request']['id']));
	    else echo $form->hidden('request_id');
		echo $form->textarea('content');
		//echo $form->input('RequestsUser.suscripted', array('type'=>'checkbox', 'label' => 'Enviarme un email cuando esta solicitud sea respondida') );
	    
	?>

    <?php echo $form->end('Responder');?>
</div>


