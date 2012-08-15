<?php
echo $javascript->link('prototype');
?>
<script type="text/javascript">
var last;
function suggest(section) {
 
    dd = $('suggdefault');
    pp = $('sugg'+section);
    
    if (section) {
        dd.hide();
        pp.show();
        
        last = pp;
    }
    else {
        last.hide();
        dd.show();
    }
    
}

</script>

  <div id="sidebar">
    <h1 class="first">Top 5</h1>
    <!--<p>sidebar</p>-->
    <ol> 
        <?php foreach($topTracks as $track): ?>
        <li><?php echo $link->makeTrack($track['Artist']['name'],$track['Track']['name']); ?></li>
        <?php endforeach; ?>
        
    </ol>
    <?php /*<!-- <div style="padding: 4px; background-color: #EF7D2A; border-bottom:1px solid #EDA36D;"><?php echo $this->element('ads-home-links'); ?></div> */?>
    <h1>Friends sites</h1>
<!--    <div style="padding: 4px; background-color: #EF7D2A; border-bottom:1px solid #EDA36D;"> -->
        <?php  App::import('Vendor', 'linklift'); ?>
        <?php  App::import('Vendor', 'textlinksads'); ?>
<!--    </div> -->
    
    <h1>Last songs</h1>
    <ul>
        <?php foreach($lastTracks as $track): ?>
        <li><?php echo $link->makeTrack($track['Artist']['name'],$track['Track']['name']); ?></li>
        <?php endforeach; ?>
    </ul>
  </div> <!-- fin sidebar -->
  
  
  
    <div id="content">

<?php /* English
   <div class="navBig">
    <div id="navSuggest">
        <div id="suggarrow"> </div>
		<div id="suggbox">   
            <div id="suggdefault" style="">Recuerda que para enviar y corregir canciones debes <strong><a href="/login">iniciar sesión</a></strong>, si no la tienes, ¡<strong><a href="/register">regístrate</a></strong>!.</div>
            <div id="suggmusic" style="display: none;">En la sección música podrás <i>explorar</i> y descubrir las canciones, <b>videos</b> más populares y a los usuarios más activos de la última semana.</div>
            <div id="suggadd" style="display: none;">También <i>puedes añadir</i> letras que no estén dentro del sitio. Luego de subir la canción, nuestro sistema buscará automáticamente <b>videos</b> de la canción en Youtube.</div>
            <div id="suggrequest" style="display: none;">Puedes pedir alguna canción que <i>aún no encuentras</i>. De la misma forma, podrás <strong>ayudar a otras personas</strong> a encontrar lo que buscan.</div>
        </div>
    </div>
    <ul>
      <li class="navMusic"><a href="<?=$this->webroot?>music" onmouseover="suggest('music')" onmouseout="suggest()">Música</a></li>
      <li class="navAdd"><a href="<?=$this->webroot?>add" onmouseover="suggest('add')" onmouseout="suggest()">Agregar</a></li>
      <!--<li class="navUser"><a href="<?=$this->webroot?>user">Usuarios</a></li>-->
      <li class="navRequest">
        <div style="color: red; font-size: 10px; position: relative; float: right; top: 120px; right: 10px;">¡Nuevo!</div>
        <a href="<?=$this->webroot?>requests" onmouseover="suggest('request')" onmouseout="suggest()">Solicitar</a>
      </li>
    </ul>
    
    
  </div>
*/
?>
    <div class="bigsearch">
      <div class="lupa"><img src="images/lupa.png" alt="logo" /></div>

      <h1>Find your favorites lyrics and songs!</h1>
      <!--<p>Búsqueda: <input type="text" class="words" /><input type="submit" value="vamos!" class="butt"/></p>-->
      
      <!--<p>
        <input type="text" class="words" value="búsqueda..." onfocus="toggleSearch(this,'búsqueda...')" onblur="toggleSearch(this,'búsqueda...')"/>
        <input type="submit" value="vamos!" class="butt"/>
      </p>-->
      
      <form action="http://www.watchlyrics.com/search" id="cse-search-box">
      <div>
        <input type="hidden" name="cx" value="partner-pub-6319622890541204:84q8ymhathk" />
        <input type="hidden" name="cof" value="FORID:9" />
        <input type="hidden" name="ie" value="UTF-8" />
        <input type="text" name="q" size="28" />
        <input type="submit" name="sa" value="Search" class="butt"/>
      </div>
    </form>
      
    </div> <!-- fin bigsearch -->
    
    <?php echo $this->element('top_artists_nube'); ?>
    
  </div> <!-- fin content -->

<?php //pr($lastTracks); ?>
