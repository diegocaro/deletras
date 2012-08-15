<div class="wide" id="content" >
<div id="recover">

<h1>Recordar contraseña</h1>
<form action="<?php echo $html->url('/recover')?>" method="POST">

<?php if (!empty($error_message)): ?>
<div class="error-message">
    <p><?php echo $error_message; ?></p>
</div>
<?php endif; ?>

<ul> 
    <li>
        <?php echo $form->input('User.email', array('label'=>'Tu email', "size" => 30, "maxlength" => 45)); ?>
    </li> 
</ul>
    <?=$form->submit('Recordar')?>
</div><!-- fin recover--> 
</div><!-- fin content-->
