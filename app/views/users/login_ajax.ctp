


<div id="content-ajax">



<div id="users-login-suggest">

<div class="register">
<p>Recuerda que para <i>editar</i> canciones debes estar registrado. </p>
<p>
¡<a href="<?php echo $html->url('/register'); ?>"><strong>Regístrate</strong></a>!
</p>
<br />
</div>

<div class="facebook">
<p>También <i>iniciar sesión</i> con tu cuenta <strong><a href="http://www.facebook.com">Facebook</a></strong> usando:</p>
<p>
<fb:login-button size="medium" background="dark" length="long" onlogin="login_page()">
</fb:login-button>
</p>
</div>

<script type="text/javascript">

FB.XFBML.Host.parseDomTree();

</script>

</div>

<!-- <h1>Iniciar sesión</h1> -->

<div class="users-login-ajax form">

<?php echo $form->create('User', array('url'=>'/login'));?>
    <fieldset>
        <!-- <legend>legend??</legend> -->
    <?php if (!empty($auth_msg)): ?>
        <div class="error-message">
            <?php echo $auth_msg; ?>
        </div>
    <?php endif; ?>
    <?php 
        echo $form->input('User.username', array('label'=>'Usuario') ); 
        echo $form->input('User.passwd', array('type' => 'password','label'=>'Contraseña') ); 
        echo $form->input('User.cookie', array('type' => 'checkbox', 'label' => 'Permanecer en línea por 1 mes') );
    ?>

    </fieldset>

    <div class="submit">
        <a href="<?php echo $html->url('/recover'); ?>">Recordar contraseña</a> o 
        <?=$form->submit('Iniciar sesión',array('div'=>false))?>
    </div>

<?php echo $form->end(); ?>

</div><!-- fin form -->
</div>
