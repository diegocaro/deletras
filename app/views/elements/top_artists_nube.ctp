<?php 
$tops = $this->requestAction("/stats/topartists/30");
?>

<div id="nube">

<?php
$max = 0;
foreach ($tops as $top) {
    //$max+=$top[0]['count'];
    if ($top[0]['count']>$max) {
        $max = $top[0]['count'];
    }
}

foreach ($tops as $top): 
    $value = $top[0]['count']/$max;
?>
    <span class="
    <?php     if ($value <= 0.2) echo "small";
          elseif ($value > 0.2 && $value <= 0.4) echo "medium";
          elseif ($value > 0.4 && $value <= 0.6) echo "big";
          elseif ($value > 0.6) echo "popular";
    ?>
    ">
    <?php echo $link->makeArtist($top['Artist']['name']); ?>
    </span>
<?php endforeach; ?>

</div> <!-- fin nube -->
