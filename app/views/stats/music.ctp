  <div id="sidebar">
    <h1 class="first">Top artistas</h1>
    <ul>
    <?php foreach ($top_artists as $top): ?>
      <li><?php echo $link->makeArtist($top['Artist']['name']); ?></li>
    <?php endforeach; ?>
    </ul>


    <h1>Top usuarios</h1>
    <ul>
    <?php foreach ($top_users as $top): ?>
      <li><?php echo $link->makeUser($top['User']['username']); ?></li>
    <?php endforeach; ?>
    </ul>
  </div> <!-- fin sidebar -->
  
  
  
  <div id="content">
    <? /*
    <h1>Buscar música</h1>
    <!--<h2 class="h2title">Búsqueda</h2>-->
    
    <div id="musicsearch">
      <!--<p>Búsqueda: <input type="text" class="words" /><input type="submit" value="vamos!" class="butt"/></p>-->
      <form action="search.html">
        <p>
          <input type="text" class="words" />
          <input type="submit" value="vamos!" class="butt"/>
        </p>
        
        <p>
						  <input type="radio" checked="" id="mtext" value="text" name="m"/> <label for="mtext">Donde sea</label>
						  <input type="radio" id="mtags" value="tags" name="m"/> <label for="mtags">Artistas</label>
						  <input type="radio" id="mtag1s" value="tags" name="m"/> <label for="mtag1s">Albums</label>
						  <input type="radio" id="mtag2s" value="tags" name="m"/> <label for="mtag2s">Canciones</label>
						  <input type="radio" id="mtag3s" value="tags" name="m"/> <label for="mtag3s">En la letra</label>
        </p>
      </form>
      
    </div><!--fin musicsearch-->
    */ ?>
    <div id="toptracks">
    
      <h1>Canciones más visitadas esta semana</h1>
      <h2 class="h2title"><?php echo $dateFrom; ?> al <?php echo $dateTo; ?></h2>
   
      <table border="0" cellspacing="0" cellpadding="0">
      <?php 
      $i=1;
      foreach ($top_tracks as $top): ?>
          <tr>
            <td class="position"><?php e($i++); ?></td>
            <td class="image"><div class="minicover">&nbsp</div></td>
            <td class="track">
              <strong><?php echo $link->makeTrack($top['Artist']['name'],$top['Track']['name']); ?></strong>
              <a><?php echo $link->makeArtist($top['Artist']['name']); ?></a>
            </td>
            <td class="stat"><?php e($top[0]['count']); ?> visitas</td>
          </tr>
       <?php endforeach; ?>
       </table>
       
    </div> <!--fin toptracks-->

  </div> <!-- fin content -->
    
    
<?php //pr($top_tracks); pr($top_artists); pr($top_users); ?>
