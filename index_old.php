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

        <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
        <ins data-revive-zoneid="37" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
        <script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>

      </div>
    </div>
  </section>


  <!-- PLAYER -->
 <div class="container-fluid px-4 px-lg-4r">
    <div class="row no-gutters">

      <div class="col-12 col-lg-12 col-xl-10 px-0 p-md-1 px-lg-0 py-xl-3 pr-xl-4">

        <div class="MultixPlayer" 
        
        style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width:100%;" allowfullscreen="true" scrolling="no" frameborder="0">


        <?php
//$hora = date('Hi');

if ($hora >= 1600 && $hora <= 2100){
  echo '<a href="https://c3ntro.zoom.us/my/tuzoom.tv"target="_self"> 
  <img class="img-fluid" src="/images/oshana.gif" width="100%"  ></a>';
}

else{
echo
  '<iframe

    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"

    src="/radiant/live.php"

    title="0" byline="0" portrait="0"

    width="640" height="360"

    scrolling="no"

    frameborder="0"

    allowtransparency="true"

    allowfullscreen=“true”

    webkitallowfullscreen="true"

    mozallowfullscreen="true"

    style="border:none"

    allowfullscreen="true"

    sandbox="allow-scripts allow-presentation allow-same-origin allow-popups"

    allow="autoplay; fullscreen; picture-in-picture; xr-spatial-tracking; encrypted-media"></iframe>';

}

?>

        </div>
      </div>

      <div class="col-12 col-lg-12 col-xl-2 px-0 p-md-1 px-lg-0 pt-lg-4 py-xl-3">
        <div class="row ads-int justify-content-between align-content-between my-4 my-lg-0" style="height:100%;">

          <div class="col-6 col-md-4 col-lg-4 col-xl-auto text-center">
            <div class="d-inline-flex">

              
              <ins data-revive-zoneid="14" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
              <script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>

            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-4 col-xl-auto text-center">
            <div class="d-inline-flex">

              
<ins data-revive-zoneid="15" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
<script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>

            </div>
          </div>
          <div class="d-none d-md-block col-md-4 col-lg-4 col-xl-auto text-center">
            <div class="d-inline-flex">

              
              <ins data-revive-zoneid="16" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
              <script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>

            </div>
          </div>

        </div>
      </div>

    </div>

  </div>
  <!-- PLAYER -->

  <section id="ads-1" class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 text-center px-4 p-md-3">

        <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
        <ins data-revive-zoneid="33" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
        <script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>

      </div>
    </div>
  </section>
  <section id="info" class="container">
    <div class="row no-gutters mb-2--">
      <div class="col-12 col-lg-6 text-center p-2">

       <!-- PLAYER -->
           	<div

  class="MultixPlayer"

  style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width:100%;" allowfullscreen="true" scrolling="no" frameborder="0">

  <iframe

    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"

    src="radiant/vod?=<?=$titvideo?>&mu=<?=$clipPromoKids?>"

    title="0" byline="0" portrait="0"

    width="640" height="360"

    scrolling="no"

    frameborder="0"

    allowtransparency="true"

    allowfullscreen=“true”

    webkitallowfullscreen="true"

    mozallowfullscreen="true"

    style="border:none"

    allowfullscreen="true"

    sandbox="allow-scripts allow-presentation allow-same-origin allow-popups"

    allow="autoplay; fullscreen; picture-in-picture; xr-spatial-tracking; encrypted-media"></iframe>


  </div>

            <!-- PLAYER -->

      </div>
      <div class="col-12 col-lg-6 text-center p-2 mt-3 mt-md-0 mt-lg-0 ads-int">

        <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
        <ins data-revive-zoneid="38" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
        <script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>

      </div>
    </div>
  </section>
  <!---->
  <!--condicionar: si no exite banner que cargar; no pintar <section id="ads-2"> -->
  <!---->
  <section id="ads-2" class="container d-none- zone-34">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 text-center p-3">

        <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
        <ins data-revive-zoneid="34" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
        <script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>

      </div>
    </div>
  </section>

  <?php include("programacion.php"); ?>

  <?php include("footer.php"); ?>
  <script type="text/javascript">
    let videos = Array();
    let URL_PORTADAS = '<?php echo URL_PORTADAS;?>';
    $(document).ready(function() {
      $.ajax({
        type: "POST",
        url: "acciones.php",
        data: {
          opcion: 'principal'
        },
        success: function(response) {
          var elemento = "";
          if (response == null || response == "null") {
            elemento = '<div>No se ha encontrado contenido</div>';
          } else {
            response = JSON.parse(response);
            clasesResponse = response;
            $.each(clasesResponse, function(i, item) {
              videos.push({
                idCategoria: item.idCategoria,
                nombre: item.nombre
              });
            });
            var elemento = "";
            var itemsvisibles = 0;
            var ultimoid = 0;
            var vermas = 1;
            var cerrado = 0;
            var totalitems = 48;
            var contador = 0;

            //console.log('<div class="row">');
            var elemento = '<div class="row no-gutters 1d">';
            $.each(videos, function(i, item) {
              if (contador == totalitems) {
                return false;
              }
              if (item !== undefined) {
                cerrado = 0;
                if (itemsvisibles == 4) {
                  //console.log('</div><div class="row">');
                  elemento += '</div><div class="row no-gutters 2d">';
                  itemsvisibles = 0;
                  cerrado = 1;
                }
                //console.log(item);
                elemento += '<div class="col-6 col-lg-3 text-center p-1" id="cat' + i + '"><a class="imageBox" href="' + item.nombre + '"><img class="img-fluid" src="' + URL_PORTADAS + '' + item.idCategoria + '_infantil.png" alt=""></a></div>';
                itemsvisibles++;
              }
              contador++
              ultimoid = i;
            });
            if (cerrado == 0) {
              elemento += '</div>';
            }
            //console.log('</div>');
            elemento += '<div id="lugar' + ultimoid + '"></div><div id="vermas' + ultimoid + '" class="row mt-5 pb-4"><div class="col-12 text-center"><a class="btn btn-primary btn-purple btn-lg--" href="javascript:void(0)" onclick="cargarmas(' + ultimoid + ')"><span class="d-block px-5 mx-5">Ver más</span></a></div></div>';
            $("#programacion").html(elemento);
            if (ultimoid == (videos.length - 1)) {
              $("#vermas" + ultimoid).css('display', 'none');
            }
          }
        }
      });
    });

    function cargarmas(ultimoid) {
      $("#vermas" + ultimoid).hide();
      var lugar = ultimoid;
      var elemento = "";
      var itemsvisibles = 0;
      var vermas = 1;
      var cerrado = 0;
      var totalitems = 4;
      var contador = 0;
      ultimoid++;
      //console.log('<div class="row">');
      var elemento = '<div class="row">';
      for (let i = ultimoid; i < videos.length; i++) {
        if (contador < totalitems) {
          cerrado = 0;
          if (itemsvisibles == 4) {
            //console.log('</div><div class="row">');
            elemento += '</div><div class="row">';
            itemsvisibles = 0;
            cerrado = 1;
          }
          elemento += '<div class="col-6 col-lg-3 text-center" id="cat' + i + '"><a class="d-block my-2" href="' + videos[i].nombre + '"><img class="img-fluid" src="' + URL_PORTADAS + '' + videos[i].idCategoria + '_infantil.png" alt=""></a></div>';
          itemsvisibles++;
          contador++
          ultimoid = i;
        }
      }
      if (cerrado == 0) {
        elemento += '</div>';
      }
      //console.log('</div>');
      elemento += '<div id="lugar' + ultimoid + '"></div><div id="vermas' + ultimoid + '" class="row mt-5 pb-4"><div class="col-12 text-center"><a class="btn btn-primary btn-purple btn-lg--" href="javascript:void(0)" onclick="cargarmas(' + ultimoid + ')"><span class="d-block px-5 mx-5">Ver más</span></a></div></div>';
      $("#lugar" + lugar).after(elemento);
      if (ultimoid == (videos.length - 1)) {
        $("#vermas" + ultimoid).css('display', 'none');
      }
    }

  </script>
</body>

</html>
