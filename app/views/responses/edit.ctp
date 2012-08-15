<div id="content" class="wide">


<div class="responses form">
<?php echo $form->create('Response');?>
	<fieldset>
 		<legend>Editar respuesta</legend>
	<?php
		echo $form->input('content', array('label'=> 'Contenido') );
		//echo $form->input('RequestsUser.suscripted', array('type'=>'checkbox', 'label' => 'Enviarme un email cuando esta solicitud sea respondida') );
	    
	?>
	</fieldset>
<?php echo $form->end('Editar');?>
</div>

</div>
