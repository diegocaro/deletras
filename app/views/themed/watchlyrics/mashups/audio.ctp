<?php
if (isset($audio_files[0])):
?>
<object width="320" height="120">
<embed src="http://www.goear.com/files/external.swf?file=<?php echo $audio_files[0]['goear_id']; ?>" type="application/x-shockwave-flash" wmode="transparent" quality="high" width="320" height="120">
</embed>
</object>
<?php else: ?>
<p>Lo sentimos, no hay audio disponible. Intenta <strong><a href="<?=$url_suggest?>">esta búsqueda</a></strong>.</p>
<?php endif; ?>
