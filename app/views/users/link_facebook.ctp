<div id="content" class="wide">



<div id="register">
<h1>Enlaza tu cuenta en deLetras con Facebook</h1>
<h2>Hola <?php echo $fbname; ?>, hay una noticia para ti</h2>
<p>Si tienes una cuenta en <strong><?php echo $html->link('deLetras.cl', '/'); ?></strong>, puedes enlazarla con tu perfil de <?php echo $html->link('Facebook', 'http://www.facebook.com'); ?>. 
Si no lo deseas, simplemente sigue buscando <?php echo $html->link('letras de canciones', array('action'=>'register_facebook')); ?>.</p>

    <div class="login form">
    <?php echo $form->create('User', array('action' => 'link_facebook'));?>
	    <fieldset>
	    
	    <?php
		    echo $form->input('username', array('label' => 'Usuario') );
            if (!empty($auth_msg)) {
                echo '<div class="error-message">'.$auth_msg. '</div>'; 
            }
		    echo $form->input('passwd', array('label'=> 'Contraseña') );
	    ?>
	    </fieldset>
        <div class="submit">
            <?php echo $html->link('No quiero enlazar mi cuenta', array('action'=>'register_facebook')); ?> o 
            <?=$form->submit('Enlazar cuentas',array('div'=>false))?>
        </div>
    </form>
    </div>
</div> <!-- fin request -->

</div>
