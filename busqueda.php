<!DOCTYPE html>
<html lang="es">

<?php include("encabezado.php");
include_once ("funciones.php");
if(!isset($db)){
  $db=conecta();  
}
$titulo = 'Ver Programa';   
$imagen_fondo = 'aventuras-fondo.png';
$busqueda = limpia_string($_POST['searchkids']);
?>
<title><?=$titulo?></title>

<body>
  <?php include("menu.php"); ?>

  <section class="container-fluid detalle-video" style="margin-top:3.8rem;background-image: url(<?php echo "images/site/$imagen_fondo";?>);">
	  
<div class="row justify-content-center ads-int">
         <div class="col-12 col-lg-10 text-center px-4 p-md-3">
            
<!-- Revive Adserver Asynchronous JS Tag - Generated with Revive Adserver v4.2.1 -->
<ins data-revive-zoneid="40" data-revive-target="_blank" data-revive-block="1" data-revive-blockcampaign="1" data-revive-id="b66a012a1acd0d45703781284cf2d38d"></ins>
<script async src="//revive.tutorah.tv/www/delivery/asyncjs.php"></script>
			 
         </div>
      </div>	  
	  
    <div class="row">
      <div class="container">
        <div class="row mt-5">
          <div class="col-12 d-flex justify-content-start">
            <a class="btn btn-light bg-white rounded-pill mr-3 shadow-sm align-self-center" href="javascript: history.go(-1)">
              <i class="fa fa-share fa-2x" style="transform: rotateY(180deg);"></i>
            </a>
            <h2 class="font-weight-bold mb-0">Busqueda: <?=$busqueda?></h2>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div id="detalle-programacion" class="container mt-3"></div>
  <?php include("footer.php"); ?>
  <script type="text/javascript">
    let programas=[];
    let videos=[];
    let URL_THUMBNAILS='<?php echo URL_THUMBNAILS;?>';
    Array.prototype.unique=function(a){
      return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
    });
    $(document).ready(function(){
      carga_videos();
    });
    function carga_videos(){
      videos.length=0;
      var busqueda = '<?php echo $busqueda;?>';
      $.ajax({
        type: "POST",
        url: "acciones.php",
        data: {opcion:'busqueda',busqueda:busqueda},
        success: function(response){
          if(busqueda==""){
            response = null;
          }
          var elemento="";
          if (response==null || response=="null"){
            $("#detalle-programacion").html('<div>No se ha encontrado contenido</div>');
          }else{
            response = JSON.parse(response);
            clasesResponse=response;
            $.each(clasesResponse, function(i, item){
              videos[item.idCategoria+'_'+item.nombre]=[];
              programas.push(item.idCategoria+'_'+item.nombre);
            });            
            programas=programas.unique();
            $.each(clasesResponse, function(i, item){
              videos[item.idCategoria+'_'+item.nombre].push({
                duracion: item.duracion,
                idMultix: item.idMultix,
                temporada: item.temporada,
                thumbnail: item.thumbnail,
                titulo: item.titulo,
                idCategoria: item.idCategoria
              });
            });

            $.each(programas, function(index, programa){
              elemento+='<div class="row"><div class="col-12 col-lg-9 mt-3 bg-info-- order-1 order-lg-2"><h3 class="px-1">'+programa.split('_')[1]+'</h3></div></div><div id="'+programa.split('_')[0]+'" class="container mt-3"></div>';
            });
            $("#detalle-programacion").html(elemento);

            $.each(programas, function(index, programa){
              var elemento = "";
              var itemsvisibles = 0;
              var ultimoid = 0;
              var vermas = 1;
              var cerrado = 0;
              var totalitems = 12;
              var contador = 0;
              var idCategoria = 0;
              elemento='<div class="row">';
              $.each(videos[programa], function(i, item){
                if(contador==totalitems){
                  return false;
                }
                if (item !== undefined){
                  cerrado = 0;
                  if(itemsvisibles == 4){
                    elemento+='</div><div class="row">';
                    itemsvisibles=0;
                    cerrado = 1;
                  }
                  elemento+='<div class="col-6 col-md-3 col-lg-3 p-lg-1 col-img"><a class="d-block my-2 imageBox" href="ver-programa.php?idCategoria='+item.idCategoria+'&vid='+item.idMultix+'&temporada='+item.temporada+'&titulo='+item.titulo+'"><!--<img class="img-fluid preViewTube" src="'+URL_THUMBNAILS+'_'+item.thumbnail+'_'+item.idMultix+'.jpg'+'" alt="">--><img class="img-fluid preViewTube" src="'+URL_THUMBNAILS+item.idMultix+'_'+item.thumbnail+'.jpg'+'" alt=""><!--<img class="img-fluid preViewTube" src="'+URL_THUMBNAILS+item.idMultix+'.jpg'+'" alt="">--><div class="textBox"><div class="icon-play"></div><p class="d-block text-truncate">'+item.titulo+'<span>'+item.duracion+'</span></p></div></a></div>';

                  itemsvisibles++;
                  idCategoria = item.idCategoria;
                }
                contador++
                ultimoid=i;
              });
              if(cerrado==0){
                elemento+='</div>';
              }
              elemento+='<div id="lugar'+programa.split('_')[0]+'_'+ultimoid+'"></div><div id="'+programa.split('_')[0]+'_vermas'+ultimoid+'" class="row mt-5 pb-4"><div class="col-12 text-center"><a class="btn btn-primary btn-purple btn-lg--" href="javascript:void(0)" onclick="cargarmas('+ultimoid+','+programa.split('_')[0]+',1,\''+programa.split('_')[1]+'\')"><span class="d-block px-5 mx-5">Ver más</span></a></div></div>';
              $("#"+programa.split('_')[0]).html(elemento);
              if(ultimoid == (videos[programa].length-1)){
                $("#"+programa.split('_')[0]+"_vermas"+ultimoid).css('display', 'none');
              }
            });
          }
          
        }
      });
    
    }
    function cargarmas(ultimoid,idCategoria,temporada,programa){
      $("#"+idCategoria+"_vermas"+ultimoid).css('display', 'none');
      var lugar = ultimoid;
      var elemento = "";
      var itemsvisibles = 0;
      var vermas = 1;
      var cerrado = 0;
      var totalitems = 12;
      var contador = 0;
      ultimoid++;

      var nomcat = idCategoria+'_'+programa;
      //console.log('<div class="row">');
      var elemento='<div class="row">';
      for(let i=ultimoid; i < videos[nomcat].length; i++){
        if(contador < totalitems){
          cerrado = 0;
          if(itemsvisibles == 4){
            //console.log('</div><div class="row">');
            elemento+='</div><div class="row">';
            itemsvisibles=0;
            cerrado = 1;
          }
          elemento+='<div class="col-6 col-md-3 col-lg-3 p-lg-1"><a class="d-block my-2 imageBox" href="ver-programa.php?idCategoria='+idCategoria+'&vid='+videos[nomcat][i].idMultix+'&temporada='+temporada+'&titulo='+videos[nomcat][i].titulo+'"><!--<img class="img-fluid" src="'+URL_THUMBNAILS+'_'+videos[nomcat][i].thumbnail+'_'+videos[nomcat][i].idMultix+'.jpg'+'" alt="">--><img class="img-fluid" src="'+URL_THUMBNAILS+videos[nomcat][i].idMultix+'_'+videos[nomcat][i].thumbnail+'.jpg'+'" alt=""><!--<img class="img-fluid" src="'+URL_THUMBNAILS+videos[nomcat][i].idMultix+'.jpg'+'" alt="">--><div class="textBox"><div class="icon-play"></div><p class="d-block text-truncate">'+videos[nomcat][i].titulo+'<span>'+videos[nomcat][i].duracion+'</span></p></div></a></div>';
          itemsvisibles++;
          contador++
          ultimoid=i;
          }
      }
      if(cerrado==0){
        elemento+='</div>';
      }
      //console.log('</div>');
      elemento+='<div id="lugar'+idCategoria+'_'+ultimoid+'"></div><div id="'+idCategoria+'_vermas'+ultimoid+'" class="row mt-5 pb-4"><div class="col-12 text-center"><a class="btn btn-primary btn-purple btn-lg--" href="javascript:void(0)" onclick="cargarmas('+ultimoid+','+idCategoria+',1,\''+programa+'\')"><span class="d-block px-5 mx-5">Ver más</span></a></div></div>';
      $("#lugar"+idCategoria+'_'+lugar).after(elemento);
      if(ultimoid == (videos[nomcat].length-1)){
        $("#"+idCategoria+"_vermas"+ultimoid).css('display', 'none');
      }
    }
  </script>
</body>

</html>
