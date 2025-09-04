<?php if (!isset($db)) $db=conecta(); 
$categorias = $db->getAll("
   SELECT
      nombre,
      REPLACE ( LOWER( nombre ), ' ', '-' ) AS link
   FROM
      categorias 
   WHERE
      idCategoria IN ( 
         SELECT
            idCategoria
         FROM
            grabaciones 
         WHERE
            idGrabacion IN ( 
               SELECT
                  idGrabacion
               FROM
                  grabacionesSecciones 
               WHERE
                  seccion = (SELECT idSeccion FROM secciones WHERE nombre = 'Infantil')
                  AND baja = 0
            )
            AND estatusWF = 6
            AND newIdMultix <> ''
            AND videoteca = 1
            AND now() > fechaDisponibilidad
            AND baja = 0
            AND soloAudio = 0
      )
      AND baja = 0
      AND visibilidadInfantil = 1
      AND portadaInfantil<>''
   ORDER BY
      nombre");?>


<nav class="navbar navbar-expand-md navbar-light bg-white fixed-top shadow-sm justify-content-center">
   <a class="navbar-brand py-0 mx-lg-4" href="home"> <img class="img-fluid" width="80" src="images/logo-tutorah-kids.png" alt="TutorahKids"></a>
   <button class="navbar-toggler fix my-1" type="button" data-toggle="collapse" data-target="#main-navigation" aria-controls="main-navigation" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
   <div class="collapse navbar-collapse fix bg-white my-1" id="main-navigation">
      <ul class="navbar-nav mr-md-auto mt-3 mt-md-0">
         <li class="nav-item active"> <a class="nav-link fw6 text-danger" href="home">Inicio</a> </li>
         <li class="nav-item dropdown">
            <a class="nav-link fw6 text-purple dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Programas</a>
            <div class="dropdown-menu megamenu mega-menu text-secondary" aria-labelledby="dropdown01">
               <div class="row">
                  <div class="col-12 col-md-4 col-lg-4">
                  <?php $i=1; foreach ($categorias as $categoria) { $param = ceil(sizeof($categorias)/3)+1; ?>
                     <a class="dropdown-item" href="<?=$categoria['link']?>"><?=$categoria['nombre']?></a>
                  <?php $i++; if ($i==$param) { $i=1; ?>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4">
                  <?php } ?>

                  <?php } // FIN FOREACH ?>
                  </div>
                  
               </div>
            </div>
         </li>
         <li class="nav-item"> <a class="nav-link fw6 text-success" href="contacto">Contacto</a> </li>
      </ul>
      <form class="form-inline my-2- my-lg-0" method="post" action="busqueda.php">
         <div id="search" class="position-relative white- gray7 mr-md-3">
            <input class="all-animate b--transparent ba bg-white-10- bg-gray1 br-pill bw1 color-inherit fw6 header-search-input- py-2 input-focus input-reset ph4" type="search" name="searchkids" value="" placeholder="Buscar...">
            <button class="button-reset color-inherint db o-80 absolute center-v right-1 glow hover-orange8" name="searchkids-submit"><i class="fas fa-search"></i></button>
         </div>

      </form> 
      <a id="btn-tuto-tv" href="https://tutorah.tv/home" target="_blank" class="btn btn-light btn-lg bg-gray1 text-blue fw6">TuTorah.tv</a>
      &nbsp;&nbsp;&nbsp;
      <a id="btn-tuto-tv" href="https://tuem.tv/home" target="_blank" class="btn btn-light btn-lg bg-gray1 text-blue fw6">TuEm.tv</a>
      &nbsp;&nbsp;&nbsp;
      <a id="btn-tuto-tv" href="https://tuia.tv" target="_blank" class="btn btn-light btn-lg bg-gray1 text-blue fw6">TuIA.tv</a>
      &nbsp;&nbsp;&nbsp;
      <a id="btn-tuto-tv" href="https://tutorah.tv/musica" target="_blank" class="btn btn-light btn-lg bg-gray1 text-blue fw6">Musica</a>
      &nbsp;&nbsp;&nbsp;
      <a id="btn-tuto-tv" href="https://tucomunidadvirtual.com" target="_blank" class="btn btn-light btn-lg bg-gray1 text-blue fw6">TuComunidad</a>
      &nbsp;&nbsp;&nbsp;
      </form> 
      
   </div>
   </div>

</nav>

