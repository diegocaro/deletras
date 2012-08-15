
<?php
/*
echo $javascript->link('prototype');
echo $javascript->link('scriptaculous');
*/
?>

<?php //echo $this->renderElement('sidebar'); ?>

<div class="wide" id="content" >

<div id="add">

<h1>¡Agrega una letra!</h1>

<div class="lyrics form">
<form action="<?php echo $html->url('/add')?>" method="POST">

    <ul>
      <li>
      <label>Artista</label>
            <?php //echo $form->text('Artist/name') ?>
            <?php echo $ajax->autoComplete('Artist.name', '/artists/autocomplete')?>
            
            <?php echo $form->error('Artist.name', '¡Artista es necesario!')?>
      </li>            
      
      <li>
      <label>Album</label>
            <?php //echo $form->text('Album/name') ?>
            <?php echo $ajax->autoComplete('Album.name', '/albums/autocomplete')?>
     <!-- <br />      
            <label>Año Album</label> <?php echo $form->text('Album/year') ?> -->
      </li>
      
      <li>
      <label>Cancion</label>
            <?php //echo $form->text('Track/name') ?>
            <?php echo $ajax->autoComplete('Track.name', '/tracks/autocomplete')?>
            <?php echo $form->error('Track.name', '¡Canción es necesaria!')?>
      </li>

      <li>
      <label>Letra</label>
      <?php echo $form->error('Lyric.text', '¡La letra es necesaria!')?>
      <?php echo
         $form->textarea('Lyric.text', array('cols'=>'40', 'rows'=>'14'));
      ?>
      </li>
    </ul> 
      
     <?=$form->submit('Agregar letra')?> 

</form>

</div> <!-- fin form -->

</div><!-- fin add-->
</div> <!-- fin content-->

