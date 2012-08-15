<?php 
$topten = $this->requestAction("/stats/toptracksbyartist/{$id}");

if (count($topten)>2): //si es que son muy pocos?>
<h1>Top <?php e(count($topten)); ?> de <?php e($link->tohtml($albumstracks['Artist']['name'])); ?></h1>
<ol>
<?php 
$one = true;
foreach ($topten as $top): ?>
    <li>
        <?php if($one) { echo "<b>"; } ?>
        <?php echo $link->makeTrack($albumstracks['Artist']['name'],$top['Track']['name']); ?>
        <?php if($one) { echo "</b>"; $one = false; } ?>
    </li>
<?php endforeach; ?>
</ol>
<?php endif; //fin count top tracks ?>
