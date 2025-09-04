<!DOCTYPE html>
<html lang="es">

<?php include("encabezado.php");
include ("funciones.php");

$autoPlay = 'no';
include ("ultimateplayervideoteca.php");

$titulo = 'TuTorahKids.tv';

## PROMOS CLIP Y VIDEO
if (!isset($db)) $db=conecta();
$promos = $db->getRow("SELECT clipPromoKids, linkClipPromoKids, linkImagenPromoKids FROM configuraciones");
?>
<title><?=$titulo?></title>

<body>
   <?php include("menu.php"); ?>

   <?php include("video.php"); ?>

   <section id="ads-1" class="container">
      <div class="row justify-content-center">
         <div class="col-12 col-lg-10 text-center p-3">
            <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
<ins data-revive-zoneid="33" data-revive-target="_blank" data-revive-block="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
<script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>
         </div>
      </div>
   </section>
   <section id="info" class="container">
      <div class="row">
         <div class="col-12 col-lg-6 text-center">
            
            <div id="myDiv"></div>
            <ul id="playlists" style="display:none;">
               <li data-source="playlist1" data-playlist-name="MY HTML PLAYLIST 1" data-thumbnail-path="content/thumbnails/large1.jpg">
               </li>
            </ul>
            
            <ul id="playlist1" style="display:none;">
               <li data-thumb-source="content/thumbnails/small-fwd.jpg" data-video-source="<?=URL_VIDEO.$promos['clipPromoKids']?>.smil/playlist.m3u8">
               </li>
            </ul>
            
         </div>
         <div class="col-12 col-lg-6 text-center mt-3 mt-md-0 mt-lg-0 ads-int">

<!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
<ins data-revive-zoneid="38" data-revive-target="_blank" data-revive-block="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
<script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>

            <!--<a href="<?=$promos['linkImagenPromoKids']?>" target="_self">
               <img class="img-fluid" src="<?=URL_ADC.'img/imagen_promo_tutorahkids.png?v='.rand(1,10000)?>" alt="">
            </a>-->
         </div>
      </div>
   </section>
   <section id="ads-2" class="container">
      <div class="row justify-content-center">
         <div class="col-12 col-lg-10 text-center p-3">
            <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
<ins data-revive-zoneid="34" data-revive-target="_blank" data-revive-block="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
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
                  var totalitems = 30;
                  var contador = 0;

                  //console.log('<div class="row">');
                  var elemento = '<div class="row">';
                  $.each(videos, function(i, item) {
                     if (contador == totalitems) {
                        return false;
                     }
                     if (item !== undefined) {
                        cerrado = 0;
                        if (itemsvisibles == 4) {
                           //console.log('</div><div class="row">');
                           elemento += '</div><div class="row">';
                           itemsvisibles = 0;
                           cerrado = 1;
                        }
                        //console.log(item);
                        elemento += '<div class="col-6 col-lg-3 text-center" id="cat' + i + '"><a class="d-block my-2" href="' + item.nombre + '"><img class="img-fluid" src="' + URL_PORTADAS + '' + item.idCategoria + '_infantil.png" alt=""></a></div>';
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
