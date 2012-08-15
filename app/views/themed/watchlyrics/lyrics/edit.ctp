
<div class="wide" id="content" >
<div id="add" class="lyrics form">

    <h1>¡Edita la letra!</h1>
    <form action="" method="POST">
    
    <ul>
    
        <li>
            <label>Artista</label> <div class="edit"><?php echo $tracks['Artist']['name']; ?></div>
        </li>
          
    <?php 
    if (!empty($tracks['Album'])): 
    foreach ($tracks['Album'] as $album):
    ?>
          <li>
              <label>Album</label> <div class="edit"><?php echo $album['name'] ?></div>
          </li>
          <?php if (!empty($tracks['Album']['date'])): ?>
          <li>     
                <label>Año Album</label> <div class="edit"><?php echo $album['date'] ?></div>
          </li>
          <?php endif; ?>
    <?php 
    endforeach;
    endif; 
    ?>      
          <li>
          <label>Cancion</label> <div class="edit"><?php echo $tracks['Track']['name']; ?></div>
          </li>

        <li>
          <label>Letra</label>
          <?php echo $form->error('Lyric.text', '¡La letra es necesaria!')?>
          <?php echo
             $form->textarea('Lyric.text', array('cols'=>'40', 'rows'=>'14', 'value'=>$tracks['Lyric'][0]['text']));
          ?>
        </li>
        
          
        <?=$form->submit('Editar letra')?> 
    </div>


</form>

</div><!-- fin add-->

</div> <!-- fin content-->
