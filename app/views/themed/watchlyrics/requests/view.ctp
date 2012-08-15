<?php
echo $javascript->link('prototype');
?>

<div id="content" class="wide">

    <div id="request">
    
        <div class="left">
            <div id="addrequest" class="actions-add">
              <?php echo $html->link('Añadir solicitud', array('action' => 'add')); ?>
            </div>
           
           <h1><?php __('Solicitudes');?></h1>
           
            <div class="item">
                <h2><?php echo $html->link($request['Request']['title'], array('action'=>'view', $request['Request']['id'])); ?></h2>
                
                <?php if ($othAuth->user('id') == $request['Request']['user_id']): ?>
                <div class="actions">
	                <ul>
		                <li class="actions-edit"><?php echo $html->link(__('Edit', true), array('action'=>'edit', $request['Request']['id'])); ?> </li>
		                <li class="actions-delete"><?php echo $html->link(__('Delete', true), array('action'=>'delete', $request['Request']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $request['Request']['id'])); ?> </li>
	                </ul>
                </div>
                <?php endif; ?>
                
                <div class="info">
                   Por <?php echo $link->makeUser($request['User']['username']); ?> <?php echo $time->timeAgoInWords($request['Request']['created'], 'j \d\e F, Y'); ?>
                </div>
                
                <p><?php echo nl2br($text->autoLink($request['Request']['content'])); ?></p>
            </div>

            <?php /**
                   * Método no usado por crear más llamadas al servidor,y es incompatible con paginator
                   * (no es capaz de ver la página que enviamos por URL)
                   *
                   
            $ResponsesIndex = $ajax->remoteFunction( 
                array( 
                    'url' => array( 'controller' => 'requests', 'action' => 'view', $request['Request']['id']), 
                    'update' => 'ResponsesIndex' 
                ) 
            ); 
            echo $javascript->codeBlock($ResponsesIndex);*/
            ?>
            
            
            <?php
            /**
             * Este método funciona muy bien, solo hay que cambiar la vista en el controlador, que se mostrarrá al usar ajax 
             */
            ?>
            
            <h1>Respuestas
                <span id="spinner" style="display: none;">
                <?php echo $html->image('/images/spinner.gif'); ?>
                </span>
                <a name="responses"></a>
            </h1>
            
            <div id="ResponsesIndex">
            <?php
            include('views/requests/view_responses_ajax.ctp');
            ?>
            </div>
            
                        
            <div id="ResponsesAdd">
            <?php 
            if ($othAuth->sessionValid()) {
                include('views/responses/add.ctp');
            }
            else { ?>
                <div id="users-login-suggest">Para responder debes <strong><a href="/login">iniciar sesión</a></strong>.</div>
            <?php
            }
            
            ?>
            </div>
            
            
            
            <div  id="RequestsSuscripted">
            <?php include('views/requests/suscripted.ctp'); ?>
            </div>
            
        </div><!-- end left-->

        <div class="right">
            <?php echo $this->element('ads-request-vertical'); ?>
        </div>

        <br clear="all" />




    </div><!-- fin request -->
</div>
