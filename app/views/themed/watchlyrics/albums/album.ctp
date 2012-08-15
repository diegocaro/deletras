<?php
echo $javascript->link('prototype');
echo $javascript->link('scriptaculous');
?>

<?php
$vid = $ajax->remoteFunction(array('url'=>"/mashups/imageartist/{$albumstracks['Artist']['name']}",'update'=>'imageartist','position'=>'top'));
echo $javascript->codeBlock($vid);

//$bio = $ajax->remoteFunction(array('url'=>"/mashups/bioartist/{$albumstracks['Artist']['name']}",'update'=>'bioartist'));
//echo $javascript->codeBlock($bio);

$alb = $ajax->remoteFunction(array('url'=>"/mashups/imagealbum/{$albumstracks['Artist']['name']}/{$albumstracks['Album']['name']}",'update'=>'imagealbum'));
echo $javascript->codeBlock($alb);

?>

<div id="sidebar">
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
    <h1><?php e($link->tohtml($albumstracks['Album']['name'])); ?></h1>
    <h2><?php e($link->makeArtist($albumstracks['Artist']['name'])); ?></h2>
    
      <div class="left">
        <!--<h2>Canciones de <?php e($albumstracks['Artist']['name']); ?></h2>-->
        <div id="imagealbum"></div>
        
        <table border="0" cellspacing="0" cellpadding="0">
          <?php foreach($albumstracks['Track'] as $track): ?>
            <tr><td class="result">
              <?php echo $link->makeTrack($albumstracks['Artist']['name'],$track['name']); ?>
            </td></tr>
          <?php endforeach; ?>
        </table>
      </div> <!-- fin left -->
      
      
      <div class="right">
        <?php echo $this->element('ads-album-box'); ?>
        
      <h2>Albumes de <?php e($link->tohtml($albumstracks['Artist']['name'])); ?></h2>
      
      <div id="minilistalbum">
      <table border="0" cellspacing="0" cellpadding="0">
        <?php foreach($albumsartist as $album): ?>
          <tr><td>
            <!-- <img style="opacity: 0.4; margin-right: 4px;" src="http://cdn.last.fm/coverart/130x130/2469689-441455144.jpg" width="50" align="left"/> -->
            <div class="minicover">
                &nbsp;
            </div>
            <div class="minialbum">
                <strong><?php echo $link->makeAlbum($albumstracks['Artist']['name'],$album['Album']['name']); ?></strong>
                <?php echo $link->makeArtist($albumstracks['Artist']['name']); ?>
                <?php if ( strtotime($album['Album']['date']) != 0): ?>
                    <?php e($album['Album']['date']); ?>
                <?php endif; ?>
            </div>
          </td></tr>
        <?php endforeach; ?>  
      </table>
      </div>
      
      </div> <!-- fin right -->

    </div><!-- fin artist-->
    
  </div> <!-- fin content-->



<?php //pr($albumstracks); ?>

