<?php
echo $javascript->link('prototype');
echo $javascript->link('scriptaculous');
?>

<?php
$vid = $ajax->remoteFunction(array('url'=>"/mashups/imageartist/{$albumstracks['Artist']['name']}",'update'=>'imageartist','position'=>'top'));
echo $javascript->codeBlock($vid);

//$bio = $ajax->remoteFunction(array('url'=>"/mashups/bioartist/{$albumstracks['Artist']['name']}",'update'=>'bioartist'));
//echo $javascript->codeBlock($bio);

//$vid = $ajax->remoteFunction(array('url'=>"/mashups/imageartist/{$albumstracks['Artist']['name']}",'complete'=>'alert(json)'));
//echo $javascript->codeBlock($vid);

?>

<div id="sidebar">
    
    <!--
    <div align="center" class="first" style="padding-top: 20px"><img src="http://cdn.last.fm/proposedimages/sidebar/6/2063956/680146.jpg" /></div>
    <h1>Biografía</h1>
    <p style="padding-left: 8px;padding-right: 8px;">Los Bunkers es una banda de rock chilena, una de las más populares del país en la primera década del siglo XXI. Se les conoce por sus sonidos de rock contemporáneo, basado en sonidos de los años 70 y de grupos desde Los Beatles hasta incorporando, adicionalmente, sonidos provenientes de la raíz folclórica. <a href="wikipedia">[+]</a></p>
    -->
    <!--<h1>Miembros</h1>    <ul><li>Francisco Duran</li><li>Mauricio Duran</li><li>Manuel Basualto</li>
    <li>Alvaro Lopez</li><li>Gonzalo Lopez</li></ul>-->
    <div align="center" class="first" style="padding-top: 20px" id="imageartist"></div>
    
    <?php echo $this->element('top_tracks_by_artist',array('id'=>$albumstracks['Artist']['id']) ); ?>
    
    <?php echo $this->element('ads-artist-links'); ?>

<!--
<h1>Artistas Similares</h1>
<ul>
<li><a href="go">Los Tres</a>
<li>Teleradio Donoso
<li>Lucybell
<li>Francisca Valenzuela
<li>Difuntos Correa
<li>Los Prisioneros
<li>Saiko
<li>Babasonicos
</ul> -->
  </div><!--fin sidebar-->


  <div id="content">
    <div id="artist">
    <h1><?php e($link->tohtml($albumstracks['Artist']['name'])); ?></h1>
    
      <div class="left">
        <h2>Songs of <?php e($link->tohtml($albumstracks['Artist']['name'])); ?></h2>

        <table border="0" cellspacing="0" cellpadding="0">
          <?php foreach($albumstracks['Track'] as $track): ?>
            <tr><td class="result">
              <?php echo $link->makeTrack($albumstracks['Artist']['name'],$track['name']); ?>
            </td></tr>
          <?php endforeach; ?>
        </table>
      </div> <!-- fin left -->
      
      
      <div class="right">
        <?php echo $this->element('ads-artist-box'); ?>
      
      <?php if(count($albumstracks['Album'])>0): ?>
      <h2>Albums of <?php e($link->tohtml($albumstracks['Artist']['name'])); ?></h2>
      
      <div id="minilistalbum">
      <table border="0" cellspacing="0" cellpadding="0">
        <?php foreach($albumstracks['Album'] as $album): ?>
          <tr><td class="result">
            <!-- <img style="opacity: 0.4; margin-right: 4px;" src="http://cdn.last.fm/coverart/130x130/2469689-441455144.jpg" width="50" align="left"/> -->
            <div class="minicover">
                &nbsp;
            </div>
            <div class="minialbum">
                <strong><?php echo $link->makeAlbum($albumstracks['Artist']['name'],$album['name']); ?></strong>
                <?php echo $link->makeArtist($albumstracks['Artist']['name']); ?>
                <?php if ( strtotime($album['date']) != 0): ?>
                    <?php e($album['date']); ?>
                <?php endif; ?>
            </div>
          </td></tr>
        <?php endforeach; ?>  
      </table>
      </div> <!-- minilistalbum -->
      <?php endif; //fin count albums?>
      </div> <!-- fin right -->

    </div><!-- fin artist-->
    
  </div> <!-- fin content-->



<?php //pr($albumstracks); ?>

