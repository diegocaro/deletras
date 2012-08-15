  <div class="wide" id="content" >
    <!--<h1>♪ Música</h1> -->

    <h1>Música</h1>
    <!--<h2 class="h2title">Búsqueda</h2>-->
       
    <div id="searchresults">
    <h2>Artistas</h2>
    <div class="left">
      
      <table border="0" cellspacing="0" cellpadding="0">
        <?php 
        $n_total = count($artists);
        
        if ($n_total > 20) {
            $n_izq = $n_total - ( $n_total - 12 ) / 2;
        }
        else {
            $n_izq = $n_total;
        }
        
        for ($i = 0; $i < $n_izq; $i++): ?>
        <tr><td class="result"><?php echo $link->makeArtist($artists[$i]['Artist']['name']); ?></td></tr>
        <?php endfor; ?>
      </table>
      
    </div> <!-- termina left -->
    
    <div class="right">
      <?php echo $this->element('ads-dir-box'); ?>

      <table border="0" cellspacing="0" cellpadding="0">
        <? for ($i = $n_izq; $i < $n_total; $i++): ?>
        <tr><td class="result"><?php echo $link->makeArtist($artists[$i]['Artist']['name']); ?></td></tr>
        <?php endfor; ?>
      </table>

    </div> <!-- termina right -->
    
  </div> <!-- fin content-->


