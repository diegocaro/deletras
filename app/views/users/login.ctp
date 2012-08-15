<div class="wide" id="content" >

<div id="register_suggest">
<p>También puedes iniciar sesión usando <strong>Facebook</strong> con:</p>
<fb:login-button size="large" background="white" length="long" onlogin="login_page()">
</fb:login-button>


<p>Recuerda que para enviar y corregir canciones debes estar <i>inscrito</i> en el sitio. ¡<a href="<?php echo $html->url('/register'); ?>"><strong>Regístrate</strong></a>!</p>

</div>

<div id="register">

<h1>Iniciar sesión</h1>
<form action="<?php echo $html->url('/login'); ?>" method="post">


<ul>
<?php if (!empty($auth_msg)): ?>
<li>
<div class="error-message">
    <?php echo $auth_msg; ?>
</div>
</li>
<?php endif; ?>


<li>
<?php echo $form->input('User.username', array('label'=>'Usuario') ); ?>
</li>
<li>
    <?php echo $form->input('User.passwd', array('type' => 'password','label'=>'Contraseña') ); ?>
</li>
<li>
<div class="checkbox">
<?php echo $form->checkbox('User.cookie'); ?>
<?php echo $form->label('User.cookie', 'Permanecer en línea por 1 mes'); ?>
</div>
</li>

</ul>

<div class="submit">
<a href="<?php echo $html->url('/recover'); ?>">Recordar contraseña</a> o 
<?=$form->submit('Iniciar sesión',array('div'=>false))?>
</div>

</form>

</div><!-- fin register-->
</div><!-- fin content-->
