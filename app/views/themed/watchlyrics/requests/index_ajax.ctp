<?php 
$paginator->options(
    array('update' => 'RequestsIndex',  // DOM id al que se le actualizará en contenido
        'indicator' => 'spinner', // DOM id que muestra el ícono "cargando"
        'complete'=>'top.location.href = "#requests";')); // Script que se ejecuta cuando termina un httprequest
?>
      
        <div id="minipaginate">       
	        <?php echo $paginator->prev('« ', array(), null, null);?>
           	<?php echo $paginator->numbers();?>
	        <?php echo $paginator->next(' »', array(), null, null);?>
        </div>
        

        <h3>Página <?php echo $paginator->counter(array('separator' => ' de ')); ?>
            
        </h3>

        <table id="data" width="100%" border="0" cellspacing="0" cellpadding="8">
          <tr>
            <th scope="col"><a href="#"><?php echo $paginator->sort('Título', 'title' );?></a></th>
            <th scope="col"><a href="#"><?php echo $paginator->sort('Núm. respuestas', 'response_count');?></a></th>
            <th scope="col"><a href="#"><?php echo $paginator->sort('Última actualización','response_updated');?></a></th>
          </tr>
          
        <?php
        $i = 0;
        foreach ($requests as $request):
	        $class = null;
	        if ($i++ % 2 == 0) {
		        $class = ' class="altrow"';
	        }
        ?>
          <tr<?php echo $class;?>>
            <td>
                <span class="title"><?php echo $html->link($request['Request']['title'], array('action'=>'view', $request['Request']['id'])); ?></span> 
                <span class="username">por <?php echo $link->makeUser($request['User']['username']); ?>.</span>
                <span class="content"><?php echo $text->truncate( Sanitize::html($request['Request']['content'], true) , 80); ?></span>
            </td>
            <td align="center" class="number"><?php echo $request['Request']['response_count']; ?></td>
            <td class="date"><?php echo $time->timeAgoInWords($request['Request']['response_updated'], 'j M Y'); ?></td>
          </tr>
        
        <?php endforeach; ?>
        </table>
      
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
