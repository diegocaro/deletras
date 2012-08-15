<?php 
echo $javascript->link('prototype');
?>

<div id="content" class="wide">



    <div id="request">
    
    <div class="left">
        <div id="addrequest" class="actions-add">
          <?php echo $html->link('Añadir solicitud', array('action' => 'add')); ?>
        </div>
        
        <h1>Solicitudes
            <span id="spinner" style="display: none;">
            <?php echo $html->image('/images/spinner.gif'); ?>
            </span>
            <a name="requests"> </a>
        </h1>
    
        <div id="RequestsAdd">
            
        </div>
        
        <div id="RequestsIndex">
        <?php
        include('views/requests/index_ajax.ctp');
        ?>
        </div>
    </div><!-- end left -->

    <div class="right">
        <?php echo $this->element('ads-request-vertical'); ?>
    </div>

    <br clear="all" />


    
    
    </div><!-- fin request-->
</div><!-- fin content-->
