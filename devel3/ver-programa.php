<!DOCTYPE html>
<html lang="es">

<?php include("encabezado.php");
include ("ultimateplayervideoteca.php");
include ("funciones.php");
if(!isset($db)){
  $db=conecta();  
}
$titulo = 'Ver Programa';   
$imagen_fondo = 'aventuras-fondo.png';

$video = limpia_string($_GET['vid']);
$datosPrograma = $db->getRow("SELECT idCategoria, temporada, titulo FROM grabaciones WHERE idMultix=?", array($video));
$idCategoria = $datosPrograma['idCategoria'];
$temporada = $datosPrograma['temporada'];
$titvideo = $datosPrograma['titulo'];

$restitulo = $db->getRow("SELECT nombre,descripcionInfantil FROM categorias WHERE idCategoria = ?",Array($idCategoria));
$videouri = $db->getRow("SELECT c.clipInfantil, sum( TIME_TO_SEC(g.duracionMultix) ) AS duracion FROM grabaciones g LEFT JOIN categorias c ON c.idCategoria = g.idCategoria WHERE estatusWF = 6 AND idMultix <> '' AND g.baja = 0 AND g.videoteca = 1 AND now() > fechaDisponibilidad AND idGrabacion IN ( SELECT idGrabacion FROM grabacionesSecciones WHERE seccion = (SELECT idSeccion FROM secciones WHERE nombre = 'Infantil' ) AND baja = 0 ) AND c.idCategoria = ?",Array($idCategoria));
$temporadas = $db->getAll("SELECT distinct(temporada) FROM tutoraht_content_admin.grabaciones WHERE baja = 0 AND videoteca = 1 AND idCategoria = ?;",Array($idCategoria));

?>
<title><?=$titulo?></title>
<body>
  <?php include("menu.php"); ?> 

  <section class="container-fluid detalle-video" style="margin-top:3.8rem;background-image: url(<?php echo URL_BACKGROUND.$idCategoria.'_infantil.png';?>);">
    <div class="row">
      <div class="container">
        
        <div class="row mt-5 mb-3">
          <div class="col-12 d-flex justify-content-start">
            <a class="btn btn-light bg-white rounded-pill mr-3 shadow-sm align-self-center" href="javascript: history.go(-1)">
              <i class="fa fa-share fa-2x" style="transform: rotateY(180deg);"></i>
            </a>
            <h2 class="font-weight-bold mb-0"><?=$titvideo?></h2>
          </div>
        </div>
        <!--/titulo-->
        <div class="row justify-content-center align-items-center">
         
          <div class="col-12 col-lg-9" style="z-index:1;">
               <div id="myDiv"></div>
               <ul id="playlists" style="display:none;">
                   <li data-source="playlist1" data-playlist-name="MY HTML PLAYLIST 1" data-thumbnail-path="content/thumbnails/large1.jpg">
                   </li>
               </ul>
               <!--  HTML playlist -->
               <ul id="playlist1" style="display:none;">
                   <li data-thumb-source="content/thumbnails/small-fwd.jpg" data-video-source="<?=URL_VIDEO.$video?>.smil/playlist.m3u8">
                   </li>
               </ul>
          </div>
          <div class="col-12 col-lg-3 order-3 order-lg-1">
            <div class="row justify-content-center align-items-center">
              <div class="col-6 col-lg-12 text-center">
                <div class="d-inline-flex ads-int">
                  <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
<ins data-revive-zoneid="35" data-revive-target="_blank" data-revive-block="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
<script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>
                </div>
              </div>
              <div class="col-6 col-lg-12 text-center mt-0 mt-lg-3 pt-0 pt-lg-3">
                <div class="d-inline-flex ads-int">
                  <!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
<ins data-revive-zoneid="36" data-revive-target="_blank" data-revive-block="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
<script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-12 col-lg-9 mt-3 order-1 order-lg-2">
            <h3 class="px-1">Descripción</h3>
            <p class="lead px-1"><?=nl2br($restitulo['descripcionInfantil'])?></p>
          </div>
          
          <div class="col-12 col-lg-3 mt-3 mb-5 mb-lg-0 order-2 order-lg-3">
            <div class="d-flex align-items-center justify-content-center" style="height:100%;">
              <div class="col-11" <?=(count($temporadas)==1)?'style="display: none;"':''?>>
                <select class="form-control border rounded" id="idTemporada" style="border-width:3px !important;" name="season" onchange="carga_videos();">
                  <?php 
                    foreach ($temporadas as $key => $value) {
                      echo "<option value='$value[0]' "; if($temporada==$value[0]){echo "selected";} echo ">Temporada $value[0]</option>";
                    }
                  ?>
                </select>
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
  
  <section id="detalle-programacion" class="container mt-3">
  </section>
  <?php include("footer.php"); ?>
  <script type="text/javascript">
    let videos=Array();
    let URL_THUMBNAILS='<?php echo URL_THUMBNAILS;?>';
    $(document).ready(function(){
      carga_videos();
    });
    function carga_videos(){
      videos.length=0;
      var idCategoria = '<?php echo $idCategoria; ?>';
      var temporada = $("#idTemporada").val();
      $.ajax({
        type: "POST",
        url: "acciones.php",
        data: {opcion:'temporadas',idCategoria:idCategoria,temporada:temporada},
        success: function(response){
          var elemento="";
          if (response==null || response=="null") {
            elemento='<div>No se ha encontrado contenido</div>';
          }else{
            response = JSON.parse(response);
            clasesResponse=response;
            $.each(clasesResponse, function(i, item) {
              videos.push({
                duracion: item.duracion,
                idMultix: item.idMultix,
                temporada: item.temporada,
                thumbnail: item.thumbnail,
                titulo: item.titulo
              });
            });
            var elemento = "";
            var itemsvisibles = 0;
            var ultimoid = 0;
            var vermas = 1;
            var cerrado = 0;
            var totalitems = 12;
            var contador = 0;

            //console.log('<div class="row">');
            
            var elemento='<div class="row">';
            $.each(videos, function(i, item){
              if(contador==totalitems){
                return false;
              }
              if (item !== undefined){
                cerrado = 0;
                if(itemsvisibles == 4){
                  //console.log('</div><div class="row">');
                  elemento+='</div><div class="row">';
                  itemsvisibles=0;
                  cerrado = 1;
                }
                //console.log(item);                
//DIV a modificar para alto de thumbnails
                elemento+='<div class="col-6 col-md-3 col-lg-3 p-lg-1"><a class="d-block my-2 imageBox" href="ver-programa?vid='+item.idMultix+'"><img class="img-fluid preViewTube" src="'+URL_THUMBNAILS+'_'+item.thumbnail+'_'+item.idMultix+'.jpg'+'" alt=""><div class="textBox"><div class="icon-play"></div><p class="d-block">'+item.titulo+'</p></div></a></div>';
//DIV a modificar para alto de thumbnails
                itemsvisibles++;
              }
              contador++
              ultimoid=i;
            });
            if(cerrado==0){
              elemento+='</div>';
            }
            
            //console.log('</div>');
            elemento+='<div id="lugar'+ultimoid+'"></div><div class="row mt-5 pb-4 alv"><div class="col-12 text-center"><a class="btn btn-primary btn-purple btn-lg" href="javascript:void(0)" id="vermas'+ultimoid+'" onclick="cargarmas('+ultimoid+','+idCategoria+','+temporada+')"><span class="d-block mx-5">Ver más</span></a></div></div>';
            $("#detalle-programacion").html(elemento);
            if(ultimoid == (videos.length-1)){
              $(".alv").hide();
            }
          }
        }
      });
    }
    function cargarmas(ultimoid,idCategoria,temporada){
      $("#vermas"+ultimoid).hide();
      var lugar = ultimoid;
      var elemento = "";
      var itemsvisibles = 0;
      var vermas = 1;
      var cerrado = 0;
      var totalitems = 12;
      var contador = 0;
      ultimoid++;
      //console.log('<div class="row">');
      var elemento='<div class="row">';
      for(let i=ultimoid; i < videos.length; i++){
        if(contador < totalitems){
          cerrado = 0;
          if(itemsvisibles == 4){
            //console.log('</div><div class="row">');
            elemento+='</div><div class="row">';
            itemsvisibles=0;
            cerrado = 1;
          }
          elemento+='<div class="col-6 col-md-3 col-lg-3 p-lg-1"><a class="d-block my-2 imageBox" href="ver-programa?vid='+videos[i].idMultix+'"><img class="img-fluid" src="'+URL_THUMBNAILS+'_'+videos[i].thumbnail+'_'+videos[i].idMultix+'.jpg'+'" alt=""><div class="textBox"><div class="icon-play"></div><p class="d-block">'+videos[i].titulo+'</p></div></a></div>';
          itemsvisibles++;
          contador++
          ultimoid=i;
          }
      }
      if(cerrado==0){
        elemento+='</div>';
      }
      //console.log('</div>');
      elemento+='<div id="lugar'+ultimoid+'"></div><div class="row mt-5 pb-4 alv"><div class="col-12 text-center"><a class="btn btn-primary btn-purple btn-lg" href="javascript:void(0)" id="vermas'+ultimoid+'" onclick="cargarmas('+ultimoid+')"><span class="d-block mx-5">Ver más</span></a></div></div>';
      $("#lugar"+lugar).after(elemento);
      if(ultimoid == (videos.length-1)){
        $(".alv").hide();
      }
    }
  </script>
</body>

</html>
