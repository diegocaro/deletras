<div id="content" class="wide">

<div id="search">
<div class="lupa"><img src="images/lupa.png" alt="logo" /></div>
<h1>Busca las letras de tus bandas favoritas!</h1>
<form action="http://www.deletras.cl/search" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="partner-pub-6319622890541204:84q8ymhathk" />
    <input type="hidden" name="cof" value="FORID:9" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="31" <?php if (isset($this->params['url']['q'])) echo 'value="'.$this->params['url']['q'].'"';?>/>
    <input type="submit" name="sa" value="Buscar" />
  </div>
</form>

</div> <!--fin search -->

<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=es"></script>

<div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = 860;
  var googleSearchDomain = "www.google.com";
  var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>



</div>
