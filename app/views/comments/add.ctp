<div class="comments-add">
<?php
if (isset($saved) && $saved) {
    // Actualizar paginación
    $View = $ajax->remoteFunction(array('url' => array('controller'=>'comments', 'action'=>'view', $this->data['Comment']['track_id'], 'page:first'), 'update' => 'CommentsView', 'indicator'=>'spinner_comments'));
    echo $javascript->codeBlock($View);
}


echo $ajax->form('add', 'post', array(
        'model'    => 'Comment',
        'url'      => array('controller' => 'comments', 'action' => 'add'),
        'update'   => 'CommentsAdd'
    ));
echo $form->textarea('content');

if (isset($track_id)) 
    echo $form->hidden('track_id', array('value' => $track_id));
else 
    echo $form->hidden('track_id');

echo $form->end('Post!');

?>
</div>
