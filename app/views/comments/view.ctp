<?php 
$paginator->options(array('url' => array('controller'=>'comments', 'action'=>'view') + $this->passedArgs)); 
$paginator->options(
    array('update' => 'CommentsView',  // DOM id al que se le actualizará en contenido
        'indicator' => 'spinner_comments', // DOM id que muestra el ícono "cargando"
        'complete'=>'top.location.href = "#comments";')); // Script que se ejecuta cuando termina un httprequest

?>

<div id="CommentsAdd">
    <?php 
    if ($othAuth->sessionValid()) {
        include('views/comments/add.ctp'); 
    }
    else { ?>
        <div id="users-login-suggest">Para comentar debes <strong><a href="/login">iniciar sesión</a></strong>.</div>
    <?php
    }
    
    ?>
</div>

<div class="comments index">

<?php
$i = 0;
foreach ($comments as $comment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
	}
?>
     <div class="item <?php echo $class;?>">
			   
            <div class="actions">
            <ul>
			<?php 
            if ($othAuth->user('id') == $comment['Comment']['user_id']): ?>
                <?php $View = $ajax->remoteFunction(array('url' => array('controller'=>'comments', 'action'=>'view', $comment['Comment']['track_id']), 'update' => 'CommentsView', 'indicator'=>'spinner_comments')); ?>
            
			    <li class="actions-delete2"><?php echo $ajax->link(__('Delete', true), array('action'=>'delete', $comment['Comment']['id']), 
			                    array( 'complete' => $View), sprintf(__('Are you sure you want to delete # %s?', true), $comment['Comment']['id'])); ?>
                </li>
		    <?php endif; ?>
		    </ul>
		    </div>
            
		    <p><strong><?php echo $link->makeUser($comment['User']['username']); ?></strong>: <?php echo nl2br($text->autoLink($comment['Comment']['content'])); ?> <span class="info"><?php echo $time->timeAgoInWords($comment['Comment']['created'], 'j \d\e F, Y'); ?> </span></p>   
    </div>			
<?php endforeach; ?>
</div>

<div id="minipaginate">
    <?php echo $paginator->prev('« anterior', array(), null, null);?>
   	<?php echo $paginator->numbers();?>
    <?php echo $paginator->next('siguiente »', array(), null, null);?>
</div>

<!-- <h3>Página <?php echo $paginator->counter(array('separator' => ' de ')); ?></h3> -->
