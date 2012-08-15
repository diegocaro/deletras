<div class="wide" id="content" >

<div id="recover">
<?php
/*
if ( isset($error) )
{
        echo '<span style="color:red;padding:7px;">Error: no such key.</span>';
}

if ( isset($pwd) )
{
    echo '<span style="color:blue;padding:7px;">Your new passwdord is <b>' . $pwd . '</b>, don\'t lose! ;-)</span> <br />';
    
    echo $html->link('login', '/login');
}*/
?>

<?php if ( isset($pwd) ): ?>

<?php /*
<p>Tu nueva contraseña es <strong><?php e($pwd); ?></strong> (no la pierdas!)</p>

<p>Y ahora... a <strong><?php echo $html->link('iniciar sesión', '/login?from=/user/+edit');?></strong>. </p>
*/ ?>

<form action="<?php echo $html->url('/login?from=/user/+edit'); ?>" method="post">
<?=$form->hidden('User.username',array('value'=>$username))?>

<p>Tu nueva contraseña es <strong><?php e($pwd); ?></strong> (no la pierdas!)</p>
<p>Y ahora... a <input type="submit" value="iniciar sesión" class="login_link"/>. </p>
</form>

<?php endif; ?>



</div>

</div><!-- fin recover--> 
</div><!-- fin content-->
