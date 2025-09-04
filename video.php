<?php include('devices.php'); ?>



<!--Si no existe id="ads-top": agregar class="mt-video" a <section id='video'> -->
<section id="video">
	<div class="video-responsive">

	<?php if (dispositivo()=="mobile" || dispositivo()=="tablet") { ?>
	<img src="images/banner.gif" style="width:100%; height:auto;">
	<?php } else { ?>
	<video width="100%" preload="auto" muted autoplay loop style="visibility: visible; width: 100%;" poster="">
		<source src="video/banner.mov" type="video/mp4">
	</video>
	<?php } ?>

	</div>
</section>