<div class="wide" id="content" >
<div id="register">
<h1>Actualizar perfil</h1>
<form  method="POST">

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

    <?=$form->submit('Actualizar')?>


</form>

</div><!-- fin register-->
</div><!-- fin content-->
