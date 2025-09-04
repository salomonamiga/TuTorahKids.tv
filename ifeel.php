<!DOCTYPE html>
<html lang="es">

<?php include("encabezado.php");
include ("funciones.php");

$autoPlay = 'no';

$titulo = 'TuTorahKids.tv';

## PROMOS CLIP Y VIDEO
if (!isset($db)) $db=conecta();
$promos = $db->getRow("SELECT clipPromoKids, linkClipPromoKids, linkImagenPromoKids FROM configuraciones");
$clips = explode(",", $promos['clipPromoKids']);
$opcion = rand(1, count($clips));
$clipPromoKids = trim($clips[$opcion-1]);
?>
<title><?=$titulo?></title>

<body>
  <?php include("menu.php"); ?>
  <section class="container mt-video" id="ads-top">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-lg-10 text-center px-4 p-md-3 mt-3 mt-lg-0">

      <img class="" src="/images/logo_ifeel3.png" title="">
		  
<!--<h1 class="letb">Material</h1>		  -->
		  
		  </div>
		  
      <iframe src="https://drive.google.com/embeddedfolderview?id=1PKYlSWwDYCTJ5h_huARaxZ4zSo3bdam7#grid" width=100% height="1000" frameborder="0" ></iframe>		
	  
</br>
      </div>
    </div>
  </section>

  
</body>

</html>

<?php include("footer.php"); ?>
