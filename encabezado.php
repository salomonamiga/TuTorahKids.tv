<?php
include_once ("funciones.php");
if(!isset($db)){
	$db=conecta();	
}

$enMantenimiento = $db->getRow("SELECT portalTutorahKidsMantenimiento, imagenMantenimientoTutorahKids FROM configuraciones");
if ($enMantenimiento['portalTutorahKidsMantenimiento']==1) {
  echo '<title>En mantenimiento | TuTorahKids.tv</title><link rel="shortcut icon" type="image/png" href="favicon.png">';
  if (empty(trim($enMantenimiento['imagenMantenimientoTutorahKids'])))
    die('En mantenimiento');
  else
    die('<img src="' . URL_ADC . 'img/imagen_tutorahkids_mantenimiento.png" style="width:100%;" />');
}

if (empty($descriptionHeader))
  $descriptionHeader = "TuTorah Kids es un espacio creado para ti, con programas rodeados de valores positivos y educativos. Diviértete, aprende y juega con nosotros.";

?>
<head>

  <?php if (isset($titulo) && !empty($titulo)) { ?>
  <title><?=$titulo?></title>
  <?php } ?>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
      <meta name="description" content="<?=$descriptionHeader?>">
      <meta name="keywords" content="TuTorahKids.tv, Tutorah Kids, Tutora Kids, Torah, Tutora, Torah, Tora, Kids, Niños, Infantil, Valores Judios, Diversion, Entretenimiento, Contenido Educativo, Educativo Judaismo, Judio, Yehudi, Mitzvot, Didactico, Musica, Aish Latino, Aish, Jabad, Jabad.com, Rab Amram Anidjar, Rab Anidjar, Anidjar, Videos, Videos Torah, Yutube, TuTorahKids.tv Niños, Tutorah Kids Niños, Tutora Kids Niños, Torah Niños, Tutora Niños, Torah Niños, Tora Niños, Kids Niños, Niños Niños, Infantil Niños, Valores Judios Niños, Diversion Niños, Entretenimiento Niños, Contenido Educativo Niños, Educativo Judaismo Niños, Judio Niños, Yehudi Niños, Mitzvot Niños, Didactico Niños, Musica Niños, Aish Latino Niños, Aish Niños, Jabad Niños, Jabad.com Niños, Rab Amram Anidjar Niños, Rab Anidjar Niños, Anidjar Niños, Videos Niños, Videos Torah Niños, Yutube Niños, TuTorahKids.tv Infantil, Tutorah Kids Infantil, Tutora Kids Infantil, Torah Infantil, Tutora Infantil, Torah Infantil, Tora Infantil, Kids Infantil, Niños Infantil, Infantil Infantil, Valores Judios Infantil, Diversion Infantil, Entretenimiento Infantil, Contenido Educativo Infantil, Educativo Judaismo Infantil, Judio Infantil, Yehudi Infantil, Mitzvot Infantil, Didactico Infantil, Musica Infantil, Aish Latino Infantil, Aish Infantil, Jabad Infantil, Jabad.com Infantil, Rab Amram Anidjar Infantil, Rab Anidjar Infantil, Anidjar Infantil, Videos Infantil, Videos Torah Infantil, Yutube Infantil, TuTorahKids.tv Kids, Tutorah Kids Kids, Tutora Kids Kids, Torah Kids, Tutora Kids, Torah Kids, Tora Kids, Kids Kids, Niños Kids, Infantil Kids, Valores Judios Kids, Diversion Kids, Entretenimiento Kids, Contenido Educativo Kids, Educativo Judaismo Kids, Judio Kids, Yehudi Kids, Mitzvot Kids, Didactico Kids, Musica Kids, Aish Latino Kids, Aish Kids, Jabad Kids, Jabad.com Kids, Rab Amram Anidjar Kids, Rab Anidjar Kids, Anidjar Kids, Videos Kids, Videos Torah Kids, Yutube Kids, ">

  <meta name="author" content="David Rivas, Victor Salgado, Mariano, Tutorah.tv">
  <link rel="shortcut icon" type="image/png" href="favicon.png">
  
  <link href="css/bs.min.css" rel="stylesheet">
  <link href="css/kidss.css?v=<?=rand(100,999);?>" rel="stylesheet">
  <link href="css/kids-rp.css?v=<?=rand(100,999);?>" rel="stylesheet">
 
  <script src="https://kit.fontawesome.com/99ab438bea.js"></script>


	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118904852-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-118904852-1');

	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-118904852-1', 'auto');
	ga('set', {
	page: '<?=str_replace(' - TuTorahKids.tv', '', $titulo)?>',
	//title: 'About'
	});  
	</script>
	<!-- End Google Analytics -->

  
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-GZJQ7CQEW7"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-GZJQ7CQEW7');

	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'G-GZJQ7CQEW7', 'auto');
	ga('set', {
	page: '<?=str_replace(' - TuTorahKids.tv', '', $titulo)?>',
	//title: 'About'
	});  
	</script>
	<!-- End Google Analytics -->

</head>
