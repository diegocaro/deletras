<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"> 
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="google-site-verification" content="P8O3FEvvA4FjG0MVZzjR9XqBiRRA0F6ap9mo62TA2go" />
  <title><?php echo $link->tohtml($title_for_layout); ?> - Letras de canciones y videoclips - deLetras.cl</title>
  <?php if ($this->params['controller']=='dashboard'): ?>
  <link rel="stylesheet" type="text/css" media="screen,projection" href="<?=$this->webroot?>css/naranjo.css"/>
  <?php elseif ($this->params['controller']=='requests'): ?>
  <link rel="stylesheet" type="text/css" media="screen,projection" href="<?=$this->webroot?>css/verde.css"/> 
  <?php elseif ( $this->params['controller'] == 'lyrics' && ($this->action=='add' || $this->action=='edit') ): ?>
  <link rel="stylesheet" type="text/css" media="screen,projection" href="<?=$this->webroot?>css/azul.css"/>
  <?php elseif ($this->params['controller'] == 'users' || $this->params['controller'] == 'recovers'): ?>
  <link rel="stylesheet" type="text/css" media="screen,projection" href="<?=$this->webroot?>css/naranjo.css"/>
  <?php else: ?> <!-- music y otros -->
  <link rel="stylesheet" type="text/css" media="screen,projection" href="<?=$this->webroot?>css/verde.css"/>
  <?php endif; ?>
  
  <link rel="alternate" type="text/xml" title="RSS" href="<?=$this->webroot?>rss.xml" />
  <link rel="shortcut icon" type="image/x-icon" href="<?=$this->webroot?>favicon.ico" />
  <!-- <base href="." /> -->
  
  <script type="text/javascript" src="<?=$this->webroot?>js/script.js"></script>
  
  <?php
        echo $html->meta('icon');

        echo $html->css('style');
        echo $html->css('header');
        echo $html->css('forms');
        
        echo $html->css('actions');
        
        //estilos facebook
        echo $html->css('facebook');
        
        
        
        //prototype + effects
        echo $javascript->link('prototype');
		echo $javascript->link('scriptaculous');
        
        //modalbox
		echo $javascript->link('modalbox');
		echo $html->css('modalbox');
		
		echo $javascript->link('cakemodalbox');
        
        
        //scripts??
        echo $scripts_for_layout;
  ?>
    <style type="text/css">
            div.disabled {
                    display: inline;
                    float: none;
                    clear: none;
                    color: #C0C0C0;
            }
    </style>

</head>

<body>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script> 
<script type="text/javascript">
function logout_page() {
  window.location = '/logout';
}

function login_page() {
  window.location = '/users/login_facebook';
}


window.onload = function() { 
FB_RequireFeatures(["XFBML"], function() { 
    FB.Facebook.init("<?php echo $facebook->api_key; ?>", "/xd_receiver.htm"); 
    FB.Facebook.get_sessionState().waitUntilReady(function() { 
        //window.alert("Session is ready"); 
        //If you want to make Facebook API calls from JavaScript do something like 
        //FB.Facebook.apiClient.friends_get(null, function(result, ex) { 
        // Do something with result 
        // window.alert("Friends list: " + result); 
        // }); 
    }); 
});
} </script>

<?php

?>

<div id="wrapper">

<div id="header">




  <div id="session">
  <span>Sitio en version <a href="http://es.wikipedia.org/wiki/Fases_del_desarrollo_de_software#Alfa" target="_blank">Alfa</a>. ¡Ayúdanos <a href="http://spreadsheets.google.com/viewform?key=pEf1TT39wtMlpyu9jtHvndA" style="color: red;" target="_blank">reportando errores</a>!.</span>
  
  <?php 
     //sesion iniciada
     //pr($this); 
    if ( $othAuth->sessionValid() ): 
        $User = $othAuth->getData('user');  
    ?>
    <!-- <span><a href="/logout">Cerrar sesión</a></span> -->
    <?php //echo $html->link($User['name'], '/user/'.$User['username']); ?>
    Bienvenido @<b><?php echo $link->makeUser($User['username']); ?></b><?php if($othAuth->user('fb_uid') != "") echo'<fb:login-button size="icon" v="2"></fb:login-button>'; else echo ',';?>
    cambia tus <a href="/user/+edit">preferencias</a> o <a href="/logout" <?php if($othAuth->user('fb_uid') != "") echo'onclick="FB.Connect.logout(function() { logout_page(); }); return false;"'; ?>>cierra sesión</a>.
    <!-- también puedes <a href="/user/+edit">cambiar</a> tu contraseña y datos personales.-->

    <!-- <br /> -->
    
  <?php else: ?>
    
    


    <a href="/register">Regístrate</a> o 
    <!--<a href="/login">Inicia sesión</a> -->
<?php
    echo $html->link('Iniciar sesión', '/login',
			array(
				'title' => 'Iniciar sesión',
				'onclick' => "Modalbox.show(this.href, {title: this.title, width: 480, transitions: false}); return false;"));
?>
    <fb:login-button size="small" length="short" onlogin="login_page()"></fb:login-button>
    
  <?php endif; ?>
  </div>
    
  
     <div id="menu">
      <ul>
        <li class="menuHome"><a href="/">Portada</a></li>
        <li class="menuMusic2"><a href="/music">Música</a></li>
        <li class="menuAdd"><a href="/add">Agregar</a></li>
        <!--<li class="menuUser"><a href="user.html">Usuarios</a></li>-->
        <li class="menuRequest">
            <div style="color: red; font-size: 9px; position: relative; float: right; top: 46px; right: -8px;">¡Nuevo!</div>
            <a href="/requests">Solicitar</a>
        </li>
      </ul>
    </div> 
  
  
  <div id="logo">
    <a href="<?=$this->webroot?>"><img src="<?=$this->webroot?>images/logo.png" alt="logo" /></a>  
  </div>

  <div id="letters">
  <ul>
    <li><a href="<?=$this->webroot?>9">#</a></li>

    <?php for ($l=97; $l<123; $l++): ?>
    <li><a href="<?=$this->webroot?><?=chr($l)?>"><?=chr($l)?></a></li>
    <?php endfor; ?>
  </ul>
  
  <?php if ($this->action!='home'): ?>
  <div class="search">
  
  <!--
    <input type="text" class="words" value="artista, album, canción..." onfocus="toggleSearch(this,'artista, album, canción...')" onblur="toggleSearch(this,'artista, album, canción...')"/>
    <input type="submit" value="buscar!" class="butt"/>
  -->  
    
    <form action="http://www.deletras.cl/search" id="cse-search-box">
      <div>
        <input type="hidden" name="cx" value="partner-pub-6319622890541204:84q8ymhathk" />
        <input type="hidden" name="cof" value="FORID:9" />
        <input type="hidden" name="ie" value="UTF-8" />
        <input type="text" name="q" size="26" />
        <input type="submit" name="sa" value="Buscar" />
      </div>
    </form>
    <script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=es"></script>

  
  </div>
  <?php endif; ?>
  
  </div> <!-- fin letters -->

<?php 

/**
 * 1/3 de las veces se muestran links
 * 2/3 de las veces se muestra el header
 */

$t = time();
if($t%3==0){
    echo $this->element('ads-global-header-links'); 
}
else {
    echo $this->element('ads-global-header'); 
}
?>


</div> <!-- fin header -->

<div id="page">
   
    <?php echo $content_for_layout ?>

</div> <!-- fin page -->


<br clear="all"/>
<div id="footer">
Bajo licencia (<a href="http://creativecommons.org/licenses/by-nc/2.0/">cc-nc</a>) <a href="<?=$this->webroot?>">bitácora de Letras</a> 2004-2011. Una idea de <a href="http://diegocaro.com">diegocaro</a>'s brain.
<span><a href="http://spreadsheets.google.com/viewform?key=pEf1TT39wtMlpyu9jtHvndA" style="color: red;" target="_blank">Reportar problema con el sitio</a></span>.
<!-- Quienes somos - Contacto - Privacidad - Términos -->



<p align="center">
<a href="http://www.blogalaxia.com/top100.php?top=1"><img src="http://botones.blogalaxia.com/img/blogalaxia0.gif" alt="BloGalaxia" style="border:0" /></a>

<a href="http://extremetracking.com/open?login=deletras"
target="_top"><img src="http://t1.extreme-dm.com/i.gif"
name="EXim" border="0" height="38" width="41"
alt="eXTReMe Tracker"></img></a>
<script type="text/javascript" language="javascript1.2"><!--
EXs=screen;EXw=EXs.width;navigator.appName!="Netscape"?
EXb=EXs.colorDepth:EXb=EXs.pixelDepth;//-->
</script><script type="text/javascript"><!--
var EXlogin='deletras' // Login
var EXvsrv='s10' // VServer
navigator.javaEnabled()==1?EXjv="y":EXjv="n";
EXd=document;EXw?"":EXw="na";EXb?"":EXb="na";
EXd.write("<img src=http://e1.extreme-dm.com",
"/"+EXvsrv+".g?login="+EXlogin+"&amp;",
"jv="+EXjv+"&amp;j=y&amp;srw="+EXw+"&amp;srb="+EXb+"&amp;",
"l="+escape(EXd.referrer)+" height=1 width=1>");//-->
</script><noscript><img height="1" width="1" alt=""
src="http://e1.extreme-dm.com/s10.g?login=deletras&amp;j=n&amp;jv=n"/>
</noscript> 

</p>



<!-- begin google analtycs -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-142921-1";
urchinTracker();
</script>
<!-- end google analtycs -->





</div> <!-- fin footer -->

</div> <!-- fin wrapper -->

</body>



</html>

