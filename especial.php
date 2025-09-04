<!DOCTYPE html>
<html lang="es">

<?php include("encabezado.php");
include("funciones.php");

$autoPlay = 'no';

$titulo = 'TuTorahKids.tv';

## PROMOS CLIP Y VIDEO
if (!isset($db)) $db = conecta();
$promos = $db->getRow("SELECT clipPromoKids, linkClipPromoKids, linkImagenPromoKids FROM configuraciones");
$clips = explode(",", $promos['clipPromoKids']);
$opcion = rand(1, count($clips));
$clipPromoKids = trim($clips[$opcion - 1]);
?>
<title><?= $titulo ?></title>

<body>
  <?php include("menu.php"); ?>
  <section class="container mt-video" id="ads-top">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-lg-10 text-center px-4 p-md-3 mt-3 mt-lg-0">

        <h1 class="letb">Transmision Especial</h1>

        <h4 class="letb">Tendremos transmisiones en vivo constantemente, sin embargo si al hacer play no te da imagen o te indica que estamos offline, te invitamos a navegar por nuestra pagina hasta que volvamos a tener transmision en vivo.</h4>

        <h7 class="letb">(En ocasiones es necesario refrescar la pagina para reactivar la transmision)</h7>

      </div>

      <!-- Embeed de Youtube -->
      <iframe width="860" height="515" src="https://www.youtube.com/embed/live_stream?channel=UCo5zxAUEZfq2PFWLnulpozA&modestbranding=1&rel=0&autoplay=0&showinfo=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <!-- Embeed de Youtube -->
    </div>

    </br>
    </div>
    </div>
  </section>


</body>

</html>

<?php include("footer.php"); ?>