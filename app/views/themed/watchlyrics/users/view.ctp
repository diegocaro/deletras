<div class="wide" id="content" >

<h1>Viendo a <?php echo $link->makeUser($user['User']['username']); ?></h1>

<div id="minipaginate">

    <?php
        echo $paginator->prev('« ', array('url'=>array($user['User']['username'])) , null, null);
    ?>
    
    <?php echo $paginator->numbers(array('url'=>$user['User']['username'])); ?>
    
    <?php    
        echo $paginator->next(' »', array('url'=>array($user['User']['username'])), null, null);
    ?> 

</div>
<h3>Canciones que ha enviado - Página <?php echo $paginator->counter(array('separator' => ' de ')); ?></h3>
    <div id="usertracks">

    <div class="left">
      
      <table border="0" cellspacing="0" cellpadding="0">
        <?php 
        $n_total = count($tracks);
        
        if ($n_total > 20) {
            $n_izq = $n_total - ( $n_total - 12 ) / 2;
        }
        else {
            $n_izq = $n_total;
        }
        $t = '';
        for ($i = 0; $i < $n_izq; $i++): ?>
            <? if ($tracks[$i]['Artist']['name']!=$t): ?>
            <tr><td class="artist">
                <? echo $link->makeArtist($tracks[$i]['Artist']['name']); ?>
            </td></tr>    
            <? endif; ?>
            
            <tr><td class="track">
                <? echo $link->makeTrack($tracks[$i]['Artist']['name'],$tracks[$i]['Track']['name']); ?>
            </td></tr>
        <?php 
            $t = $tracks[$i]['Artist']['name'];
        endfor; ?>
      </table>
      
    </div> <!-- termina left -->
    
    <div class="right">
      <?php echo $this->element('ads-user-box'); ?>

      <table border="0" cellspacing="0" cellpadding="0">
        <? 
        $t = '';
        for ($i = $n_izq; $i < $n_total; $i++): ?>
            <? if ($tracks[$i]['Artist']['name']!=$t): ?>
            <tr><td class="artist">
                <? echo $link->makeArtist($tracks[$i]['Artist']['name']); ?>
            </td></tr>    
            <? endif; ?>
            
            <tr><td class="track">
                <? echo $link->makeTrack($tracks[$i]['Artist']['name'],$tracks[$i]['Track']['name']); ?>
            </td></tr>
        <?php 
            $t = $tracks[$i]['Artist']['name'];
        endfor; ?>
      </table>

    </div> <!-- termina right -->
    </div> <!-- termina usertracks -->

    <br clear="all" />
    
    <div id="paginate">
        <!-- Shows the next and previous links -->
        <div class="prev">
        <?php
	        echo $paginator->prev('« Anterior ', array('url'=>array($user['User']['username'])) , null, null);
	    ?>
	    </div>
	    <div class="next">
	    <?php    
	        echo $paginator->next(' Siguiente »', array('url'=>array($user['User']['username'])), null, null);
        ?> 
        </div>
        
        <div class="numbers">
	        <!-- Shows the page numbers -->
        <?php echo $paginator->numbers(array('url'=>$user['User']['username'])); ?>
        </div>
	    
    </div>
</div><!-- fin content-->



<?php //pr($tracks); ?>
