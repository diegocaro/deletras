<div id="content" class="wide">

<div id="request">
    <div class="requests form">
    <?php echo $form->create('Request');?>
	    <fieldset>
     		<legend>Envía una solicitud</legend>
	    <?php
		    echo $form->input('title', array('label' => 'Título') );
		    echo $form->input('content', array('label'=> 'Contenido') );
		    echo $form->input('RequestsUser.suscripted', array('type'=>'checkbox', 'label' => 'Enviarme un email cuando esta solicitud sea respondida') );
	    ?>
	    </fieldset>
    <?php echo $form->end('Enviar solicitud');?>
    </div>
</div> <!-- fin request -->

</div>
