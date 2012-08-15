<div class="wide" id="content" >
<h1>Usuarios</h1>

<h3>Usuarios más populares</h3>
    <table border="0" cellspacing="0" cellpadding="0">
      <?php foreach($contributors as $user): ?>
        <tr><td class="result">
          
          <?php echo $link->makeUser($user['User']['username']); ?>, con <?php echo $user['T']['count']; ?> letras enviadas y/o editadas.
        </td></tr>
      <?php endforeach; ?>
    </table>


</div><!-- fin content-->

<?php //pr($user); ?>
