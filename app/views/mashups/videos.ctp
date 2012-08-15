<ul>
<? foreach($videos as $video): ?>
<li>
   <?php /*<!-- <a href="#" onclick="openVideo('<?=$video['id']?>')">
        <img align="left" style="margin-right: 4px;" width="60" border="0" src="http://img.youtube.com/vi/<?=$video['id']?>/2.jpg" title="<?=$video['title']?>"/>
        <div style="display: block;"><?=$video['title']?></div>
    </a>
    <br clear="both" />
    --> */ ?>
    <a href="#" onclick="openVideo('<?=$video['id']?>'); return false;">
        <img width="70" border="0" src="http://img.youtube.com/vi/<?=$video['id']?>/2.jpg" title="<?=$video['title']?>"/>
    </a>
</li>
<? endforeach; ?>
</ul>

<?php if (count($videos)>0) :?>
<script type="text/javascript">
openVideo('<?=$videos[0]['id']?>',0);
</script>
<?php else: ?>
<p>Lo sentimos, no hay videos disponibles. Intenta <strong><a href="<?=$url_suggest?>">esta búsqueda</a></strong>.</p>
<?php endif; ?>
