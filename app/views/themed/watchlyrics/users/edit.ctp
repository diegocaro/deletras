<div class="wide" id="content" >
<div id="register">

<h1>Editando a <?php echo $link->makeUser($username); ?></h1>

<form method="POST" action="<?php echo $html->url('/user/+edit' ); ?>">
<ul>
    <li>
        <?php echo $form->input('User.name', array('label'=>'Nombre') ); ?>
    </li>
    <li>
        <?php echo $form->input('User.email', array('label'=>'E-mail') ); ?> 
        <span>(acá se te enviará la contraseña si la pierdes).</span>
    </li>
    <li>
        <?php echo $form->input('User.new_passwd', 
                    array('type' => 'password','label'=>'Nueva contraseña') ); ?> 
        <span>(sensible a mayúsculas, entre 5 y 10 símbolos).</span>
    </li>
    
    <li>
        <?php echo $form->input('User.confirm_passwd', 
                    array('type' => 'password',
                            'label'=>'Re-escribe Nueva contraseña') ); ?>
    </li>
</ul>

<?php echo $form->submit('Guardar cambios'); ?>

</form>

</div><!-- fin register-->

</div> <!-- fin content-->
