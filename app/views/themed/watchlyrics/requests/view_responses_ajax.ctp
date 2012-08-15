<?php 

$paginator->options(array('url' => array('controller'=>'requests', 'action'=>'view') + $this->passedArgs)); 
$paginator->options(
    array('update' => 'ResponsesIndex',  // DOM id al que se le actualizará en contenido
        'indicator' => 'spinner', // DOM id que muestra el ícono "cargando"
        'complete'=>'top.location.href = "#responses";')); // Script que se ejecuta cuando termina un httprequest

?>

<div id="minipaginate">
    <?php echo $paginator->prev('« ', array(), null, null);?>
   	<?php echo $paginator->numbers();?>
    <?php echo $paginator->next(' »', array(), null, null);?>
</div>

<h3>Página <?php echo $paginator->counter(array('separator' => ' de ')); ?></h3>

<?php
$i = 0;
foreach ($responses as $response):
    $class = null;
    if ($i++ % 2 == 0) {
        $class = 'altrow';
    }
?>
    <div class="item <?php echo $class;?>">
        
        <?php if ($othAuth->user('id') == $response['Response']['user_id']): ?>
        <div class="actions">
            <ul>
                <li class="actions-edit"><?php echo $html->link(__('Edit', true), array('controller' => 'responses', 'action'=>'edit', $response['Response']['id'])); ?> </li>
                <li class="actions-delete"><?php echo $html->link(__('Delete', true), array('controller' => 'responses', 'action'=>'delete', $response['Response']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $response['Response']['id'])); ?> </li>
            </ul>
        </div>
        <?php endif; ?>
        
        <div class="info">
            Por <?php echo $link->makeUser($response['User']['username']); ?> <?php echo $time->timeAgoInWords($response['Response']['created'], 'j \d\e F, Y'); ?>
        </div>
            
        <p><?php echo nl2br($text->autoLink($response['Response']['content'])); ?></p>              
    </div>
<?php endforeach; ?>


<div id="paginate">
    <div class="prev">
        <?php echo $paginator->prev('« '.__('Anterior', true), array(), null, null);?>
    </div>
    <div class="next">
        <?php echo $paginator->next(__('Siguiente', true).' »', array(), null, null);?>
    </div>
    <div class="numbers">
        <?php echo $paginator->numbers();?>
    </div>
</div>

<br />
