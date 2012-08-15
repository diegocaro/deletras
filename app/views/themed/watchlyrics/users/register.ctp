<div class="wide" id="content" >

<div id="register_suggest">
<p>Si tienes una cuenta en <strong>Facebook</strong>, puedes saltarte el formulario simplemente usando:</p>
<fb:login-button size="large" background="white" length="long" onlogin="login_page()">
</fb:login-button>
<p></p>
</div>


<div id="register">
<h1>Registrar usuario</h1>

<div class="users form">

<?php /*<form action="<?php echo $html->url('/register')?>" method="POST"> */?>
<?php echo $form->create('User', array('url'=>'/register')); ?>

<ul>
<li>
    <?php echo $form->input('User.username', array('label'=>'Usuario') ); ?>
    <span> (5 letras, en min&uacute;sculas, sin espacios, sin acentos).</span>
</li>
<li>
    <?php echo $form->input('User.new_passwd', array('type' => 'password','label'=>'Contraseña') ); ?>
    <span> (sensible a mayúsculas, entre 5 y 10 símbolos).</span>
</li>

<li>
    <?php echo $form->input('User.confirm_passwd', array('type' => 'password','label'=>'Re-contraseña') ); ?>
</li>

<li>
    <?php echo $form->input('User.name', array('label'=>'Nombre') ); ?>
</li>

<li>

    <?php echo $form->input('User.email', array('label'=>'E-mail') ); ?> 
    <span>(acá se te enviará la contraseña si la pierdes).</span>
</li>
</ul>

    <?=$form->end('Regístrate')?>
</div> <!--fin form -->

</div><!-- fin register-->
</div><!-- fin content-->

