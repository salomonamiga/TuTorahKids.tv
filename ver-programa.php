<!DOCTYPE html>
<html lang="es">

<?php
include("funciones.php");
if (!isset($db)) {
  $db = conecta();
}

$video = limpia_string($_GET['vid']);


$datosPrograma = $db->getRow("
  SELECT
    g.idCategoria,
    g.temporada,
    g.titulo,
    g.duracionMultix AS duracion,
    g.tags,
    c.descripcionInfantil AS descripcion,
    c.nombre AS categoria
  FROM
    grabaciones g
  LEFT JOIN
    categorias c ON c.idCategoria = g.idCategoria
  WHERE
    g.newIdMultix=?
    AND g.videoteca=1
    AND g.baja=0", array($video));

if (sizeof($datosPrograma) == 0) {
  echo '<script type="text/javascript">location.href="https://tutorahkids.tv";</script>';
  exit();
}

$titulo = $datosPrograma['categoria'] . "/ " . $datosPrograma['titulo'] . " - TuTorahKids.tv";
$duracion = formato_tiempo_youtube($datosPrograma['duracion']);
$descriptionHeader = $datosPrograma['titulo'] . " - " . $duracion . " (" . str_replace(",", " / ", $datosPrograma['tags']) . ").\n" . $datosPrograma['descripcion'];
include("encabezado.php");

$titulo = 'Ver Programa';
$imagen_fondo = 'aventuras-fondo.png';

$idCategoria = $datosPrograma['idCategoria'];
$temporada = $datosPrograma['temporada'];
$titvideo = $datosPrograma['titulo'];
$categoria_url = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($datosPrograma['categoria'])));

// Detectar si es el programa específico que necesita intro
$mostrar_intro = (strpos($_SERVER['REQUEST_URI'], 'la-perasha-en-ia-escuelas') !== false);
$intro_param = $mostrar_intro ? '&intro=donacion' : '';

$restitulo = $db->getRow("SELECT nombre,descripcionInfantil FROM categorias WHERE idCategoria = ?", array($idCategoria));
$videouri = $db->getRow("SELECT c.clipInfantil, sum( TIME_TO_SEC(g.duracionMultix) ) AS duracion FROM grabaciones g LEFT JOIN categorias c ON c.idCategoria = g.idCategoria WHERE estatusWF = 6 AND newIdMultix <> '' AND g.baja = 0 AND g.videoteca = 1 AND now() > fechaDisponibilidad AND idGrabacion IN ( SELECT idGrabacion FROM grabacionesSecciones WHERE seccion = (SELECT idSeccion FROM secciones WHERE nombre = 'Infantil' ) AND baja = 0 ) AND c.idCategoria = ?", array($idCategoria));

?>
<title><?= $titulo ?></title>

<body>
  <?php include("menu.php"); ?>

  <section class="container-fluid detalle-video mt-video" style="background-image: url(<?php echo URL_BACKGROUND . $idCategoria . '_infantil.png'; ?>);">

    <div class="row justify-content-center ads-int">
      <div class="col-12 col-lg-10 text-center px-4 p-md-3">
        <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
        <ins data-revive-zoneid="39" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
        <script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>
      </div>
    </div>
    <!--/row-->
    <div class="row">
      <div class="container">
        <div class="row mt-0 mb-3">
          <div class="col-12 d-flex justify-content-start">
            <a class="btn btn-light bg-white rounded-pill mr-3 shadow-sm align-self-center" href="javascript: history.go(-1)">
              <i class="fa fa-share fa-2x" style="transform: rotateY(180deg);"></i>
            </a>
            <h2 class="font-weight-bold mb-0"><?= $titvideo ?></h2>
          </div>
        </div>
        <!--/titulo-->
        <div class="row no-gutters justify-content-center align-items-center">
          <div class="col-12 col-lg-9 p-1" style="z-index:1;">
            <!-- PLAYER -->
            <div class="MultixPlayer" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width:100%;" allowfullscreen="true" scrolling="no" frameborder="0">
              <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="radiant/vod?=<?= $titvideo ?>&mu=<?= $video ?><?= $intro_param ?>" title="0" byline="0" portrait="0" width="640" height="360" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" style="border:none;" allowfullscreen sandbox="allow-scripts allow-presentation allow-same-origin" allow="autoplay; fullscreen; picture-in-picture; xr-spatial-tracking; encrypted-media"></iframe>
            </div>
            <!-- PLAYER -->
          </div>
          <div class="col-12 col-lg-3 p-1 order-3 order-lg-1">
            <div class="row no-gutters justify-content-center">
              <div class="col-6 col-lg-12 p-1 text-center">
                <div class="d-inline-flex ads-int">
                  <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
                  <ins data-revive-zoneid="35" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
                  <script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>
                </div>
              </div>
              <div class="col-6 col-lg-12 p-1 text-center mt-0 mt-lg-3-- pt-0 pt-lg-3">
                <div class="d-inline-flex ads-int">
                  <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
                  <ins data-revive-zoneid="36" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
                  <script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-12 p-1 mt-3 order-1 order-lg-2">
            <div class="row justify-content-start">
              <div class="col-12 col-md-12 col-lg-9">
                <h3 class="px-1">Descripción</h3>
                <p class="lead px-1"><?= nl2br($restitulo['descripcionInfantil']) ?></p>
              </div>
            </div>
          </div>
        </div>
        <!--/row-->
      </div>
      <!--/container-->
    </div>
    <!--/row-->
  </section>
  <!--container-fluid-->

  <section id="detalle-programacion" class="container mt-0 mt-lg-3"></section>
  <?php include("footer.php"); ?>
  <script type="text/javascript">
    // Variables globales
    let videos = Array();
    let temporadasTxt = Array();
    let videoscat = Array([], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], [], []);
    let URL_THUMBNAILS = '<?php echo URL_THUMBNAILS; ?>';
    let categoriaUrl = '<?php echo $categoria_url ?>';

    $(document).ready(function() {
      let Categoria = '<?php echo $idCategoria ?>';
      $.ajax({
        data: {
          accion: 'cargarvideos',
          id: Categoria
        },
        url: 'cargarvideos.php',
        type: 'post',
        success: function(response) {
          var elemento = "";
          if (response == null || response == "null") {
            elemento = '<div>No se ha encontrado contenido</div>';
          } else {
            response = JSON.parse(response);
            clasesResponse = response;

            numTemporadas = 0;
            currentTemporada = 0;
            $.each(clasesResponse, function(i, item) {
              if (currentTemporada != item.temporada) {
                numTemporadas++;
                currentTemporada = item.temporada;
              }

              videos[item.temporada] = [item.temporada];
              temporadasTxt[item.temporada] = [item.temporada2];
              videoscat[item.temporada].push(item);
            });

            var elemento = "";
            $.each(videos, function(i, item) {
              if (item !== undefined) {
                var itemsvisibles = 0;
                var ultimoid = 0;
                var total = videoscat[item].length - 1;
                var vermas = 1;

                if (numTemporadas > 1)
                  elemento += '<div class="row my-3"><div class="col-12 col-md-12"><h2 class="titulo-temporadas font-weight-bold mb-0 mx-1">' + temporadasTxt[item] + '</h2></div></div>';
                
                elemento += '<div class="row no-gutters">';
                for (let i = 0; i < videoscat[item].length; i++) {
                  if (itemsvisibles < 12) {
                    elemento += '<div class="col-6 col-md-3 col-lg-3 p-1 col-img __ver__programa" id="video_' + item + '_' + i + '"><a class="imageBox" href="ver-programa?' + categoriaUrl + '&vid=' + videoscat[item][i].idMultix + '"><img class="img-fluid preViewTube" src="' + URL_THUMBNAILS + videoscat[item][i].idMultix + '_' + videoscat[item][i].thumbnail + '.jpg" alt=""><div class="textBox"><div class="icon-play"></div><p class="d-block text-truncate--">' + videoscat[item][i].titulo + '<span>' + videoscat[item][i].duracion + '</span></p></div></a></div>';

                    ultimoid = i;
                    if (i == total) {
                      vermas = 0;
                    }
                  }
                  itemsvisibles++;
                }

                elemento += '</div>';
                if (vermas == 1) {
                  elemento += '<div id="grupo_' + item + '" ></div><div id="masd_' + item + '" style="text-align:center;"><button id="mas" class="btn btn-primary btn-purple w-50 mt-5 mt-1" onclick="loadMore(\'' + item + '\',\'video_' + item + '_' + ultimoid + '\',\'' + ultimoid + '\')">Ver más <span class="fa fa-angle-double-down"></span></button></div>';
                }
              }
            });
            $("#detalle-programacion").html(elemento);
          }
        }
      });
    });

    function loadMore(item, ultimovideo, ultimoid) {
      itemsvisibles = 0;
      elemento = "";
      ultimoid++;
      var total = videoscat[item].length - 1;
      var vermas = 1;
      for (let i = ultimoid; i < videoscat[item].length; i++) {
        if (itemsvisibles < 12) {
          elemento += '<div class="col-6 col-md-3 col-lg-3 p-1 col-img __ver__programa" id="video_' + item + '_' + i + '"><a class="imageBox" href="ver-programa?' + categoriaUrl + '&vid=' + videoscat[item][i].idMultix + '"><img class="img-fluid preViewTube" src="' + URL_THUMBNAILS + videoscat[item][i].idMultix + '_' + videoscat[item][i].thumbnail + '.jpg" alt=""><div class="textBox"><div class="icon-play"></div><p class="d-block text-truncate--">' + videoscat[item][i].titulo + '<span>' + videoscat[item][i].duracion + '</span></p></div></a></div>';
          ultimoid = i;
          if (i == total) {
            vermas = 0;
          }
        }
        itemsvisibles++;
      }
      $("#" + ultimovideo).after(elemento);
      $("#masd_" + item).remove();

      if (vermas == 1) {
        $("#grupo_" + item).after('<div id="masd_' + item + '" style="text-align:center;"><button id="mas" class="btn btn-primary btn-purple w-50 mt-5 mt-1" onclick="loadMore(\'' + item + '\',\'video_' + item + '_' + ultimoid + '\',\'' + ultimoid + '\')">Ver más <span class="fa fa-angle-double-down"></span></button></div>');
      }
    }
  </script>
</body>
</html>