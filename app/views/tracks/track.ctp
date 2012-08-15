<?php
echo $javascript->link('prototype');
echo $javascript->link('scriptaculous');

$vid = $ajax->remoteFunction(array('url'=>"/mashups/videos/{$query_video['artist']}/{$query_video['track']}",'update'=>'listvideo','indicator'=>'spinner_video'));
$aid = $ajax->remoteFunction(array('url'=>"/mashups/audio/{$query_video['artist']}/{$query_video['track']}",'update'=>'embedaudio','indicator'=>'spinner_audio'));
$cid = $ajax->remoteFunction(array('url'=>"/comments/view/{$track['Track']['id']}",'update'=>'CommentsView','indicator'=>'spinner_comments'));


?>


<script type="text/javascript">
function openVideo (vid,auto) {
    
    var embedvideo = $('embedvideo');
    var html="";
    var autoplay="";
    
    if (auto==0) 
        autoplay = 'autoplay=0';
    else
        autoplay = 'autoplay=1';
        
    embedvideo.style.display = 'block';
    embedvideo.style.height = 'auto';
    //spinner_viewer.style.margin = '5px 0px 10px 30px';
    embedvideo.style.margin = '0px 0px 0px 0px';

    html += '<table cellspacing=0 cellpadding=0><tr><td><embed src=\"http://www.youtube.com/v/'+ vid +'&' + autoplay + '\" type=\"application/x-shockwave-flash\" width=\"320\" height=\"262\" bgcolor=\"white\" wmode=\"transparent\"></embed></td><td valign="top"><div class="close"><a href=\"#\" onclick=\"javascript:closeVideo();\" title="Cerrar video">&nbsp;</a></div></td></tr></table>';
    embedvideo.innerHTML = html;
}

function closeVideo() {
    var embedvideo = $('embedvideo');
    embedvideo.style.display = 'none';
    embedvideo.style.height = '0px';
    embedvideo.style.margin = '0px';
    embedvideo.innerHTML = '';
}

/* Not used
function loadingVideos() {
    var listvideo = $('listvideo');
    listvideo.innerHTML = 'Cargando...';
}


function onstart() {
<?php
echo $vid.";\n";
echo $aid.";\n";
echo $cid.";\n";
?>
}
*/
</script>

<?php /*
<div id="sidebar">

    <h1 class="first">Álbumes con esta canción</h1>
    <div id="minilistalbum">
    <ul>
    <?php foreach($track['Album'] as $album): ?>
      <li>
        <div class="minicover">
            &nbsp;
        </div>
        <div class="minialbum">
            <strong><?php echo $link->makeAlbum($track['Artist']['name'],$album['name']); ?></strong>
            <?php echo $link->makeArtist($track['Artist']['name']); ?>
            <?php if ( strtotime($album['date']) != 0): ?>
                <?php e($album['date']); ?>
            <?php endif; ?>
        </div>
      </li>
    <?php endforeach; ?>  
    </ul>
    </div>



    
    <div ><h1><?php e($track['Track']['name']); ?> @youtube</h1></div>
    <div id="listvideo"></div>

</div><!--fin sidebar-->
<?php */ ?> 
<div id="content" class="wide">
    <div id="track">
        
        
        <div class="left">
            <div id="menutrack">            
                <div class="actions-edit">
                    <?php echo $link->makeEdit($track['Artist']['name'],$track['Track']['name'],'Edita esta letra'); ?>, 
                    última edición por @<?php echo $link->makeUser($track['User']['username']); ?>
                </div>
                        
            
                <div class="addthis">
                    <!-- AddThis Button BEGIN -->
                    <script type="text/javascript">
                        var addthis_pub="diegocaro";
                        var addthis_language = "es"; 
                        var addthis_localize = {email: "Email", favorites: "Favoritos" }
                        var addthis_options = 'email, favorites, facebook, delicious, myspace, google, live, twitter, more';
                    </script>   
                    <a href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()">
                        <img src="http://s7.addthis.com/static/btn/lg-share-es.gif" width="125" height="16" alt="Bookmark and Share" style="border:0" align="top"/>
                    </a>
                    <script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script>
                    <!-- AddThis Button END -->
                </div>
  
            </div>
            
            <div id="infotrack">
                <h1><?php e($link->tohtml($track['Track']['name']));?></h1>
                <h2>por <?php e($link->makeArtist($track['Artist']['name']));?></h2>
            </div>
            <p class="lyric"><?php e(nl2br($link->tohtml($track['Lyric'][0]['text'])));?></p>
            
            <div id="listcomments">
                <h2>Comentarios de <?php e($link->tohtml($track['Track']['name']));?>
                <span id="spinner_comments" style="display: none;">
                <?php echo $html->image('/images/spinner.gif'); ?>
                </span>
                <a name="comments"></a>
                </h2>
                <div id="CommentsView"> </div>
                
            </div>
            <?php echo $javascript->codeBlock($cid); ?>
        </div> <!-- fin left -->
        
        <div class="right">
            
            <h3>Música de <?php echo $track['Track']['name']; ?> (<?php echo $link->makeArtist($track['Artist']['name']); ?>)
                <span id="spinner_audio" style="">
                <?php echo $html->image('/images/spinner.gif'); ?>
                </span>
            </h3>
            <div id="embedaudio"></div>
            <?php echo $javascript->codeBlock($aid); ?>
            
            <?php echo $this->element('ads-track-links'); ?>
            
            <h3>Videos de <?php echo $track['Track']['name']; ?> (<?php echo $link->makeArtist($track['Artist']['name']); ?>)
                <span id="spinner_video" style="">
                <?php echo $html->image('/images/spinner.gif'); ?>
                </span>
            </h3>
            
            <div id="embedvideo"></div>
            <?php echo $javascript->codeBlock($vid); ?>
            
            <div id="listvideo"></div>
            <br clear="both" />
            
            <?php echo $this->element('ads-track-box'); ?>
            
            <?php ///* 
            if (count($track['Album']) > 0):
            ?>
            <h2>Álbumes con esta canción</h2>
            <div id="minilistalbum">
            <table border="0" cellspacing="0" cellpadding="0" >
            <?php foreach($track['Album'] as $album): ?>
              <tr><td class="result">
                <!-- <img style="opacity: 0.4; margin-right: 4px;" src="http://cdn.last.fm/coverart/130x130/2469689-441455144.jpg" width="50" align="left"/> -->
                <div class="minicover">
                    &nbsp;
                </div>
                <div class="minialbum">
                    <strong><?php echo $link->makeAlbum($track['Artist']['name'],$album['name']); ?></strong>
                    <?php echo $link->makeArtist($track['Artist']['name']); ?>
                    <?php if ( strtotime($album['date']) != 0): ?>
                        <?php e($album['date']); ?>
                    <?php endif; ?>
                </div>
              </td></tr>
            <?php endforeach; ?>  
            </table>
            </div>
            <?php 
            endif; //count
            //*/ ?>
          
        </div> <!-- fin right -->
        
    </div> <!-- fin track-->
</div> <!-- fin content-->







<?php //pr($track); ?>
