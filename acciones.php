<?php 
include ("funciones.php");
if(!isset($db)){
	$db=conecta();	
}

$opcion = $_POST['opcion'];
//$opcion='principal';
// para agregar que no se muestren cosas sin clip o descripcion agregar AND clipInfantil <> '' AND descripcionInfantil <> ''
if($opcion=='principal'){
	$categorias = $db->getAll("SELECT idCategoria, REPLACE ( LOWER( nombre ), ' ', '-' ) as nombre FROM categorias 
		WHERE idCategoria IN ( 
			SELECT idCategoria FROM grabaciones 
			WHERE idGrabacion IN ( 
				SELECT idGrabacion FROM grabacionesSecciones 
				WHERE seccion = (SELECT idSeccion 
					FROM secciones WHERE nombre = 'Infantil' ) AND baja = 0 ) AND estatusWF = 6 AND newIdMultix <> '' AND videoteca = 1 AND now() > fechaDisponibilidad AND baja = 0 AND soloAudio = 0) AND baja = 0 AND visibilidadInfantil = 1  AND portadaInfantil<>'' ORDER BY rand()");
	echo json_encode($categorias);
}
if($opcion=='temporadas'){
	$idCategoria = $_POST['idCategoria'];
	$temporada = $_POST['temporada'];

	// Obtengo orden por defecto del programa
	$ordenMaterial = $db->getOne("SELECT ordenMaterialInfantil FROM categorias WHERE idCategoria = ?", array($idCategoria));
	$orden = $ordenMaterialPaginaInstruccion[$ordenMaterial];

	$videos = $db->getAll("SELECT titulo, duracionMultix AS duracion, newIdMultix AS idMultix, thumbnail, temporada, REPLACE ( LOWER( c.nombre ), ' ', '-' ) AS categoria FROM grabaciones g 
			LEFT JOIN categorias c ON c.idCategoria = g.idCategoria 
			WHERE estatusWF = 6 AND newIdMultix <> '' AND g.baja = 0 AND g.videoteca = 1 and g.temporada = ? AND now() > fechaDisponibilidad AND idGrabacion IN (
				SELECT idGrabacion FROM grabacionesSecciones WHERE seccion = ( SELECT idSeccion FROM secciones WHERE nombre = 'Infantil' ) AND baja = 0 ) AND c.idCategoria = ? ORDER BY temporada, $orden",Array($temporada,$idCategoria));

			foreach ($videos as $key => $value)
				$videos[$key]['duracion'] = formato_tiempo_youtube($videos[$key]['duracion']);

	echo json_encode($videos);
}

if($opcion=='busqueda'){
	$busqueda = $_POST['busqueda'];
	$videos = $db->getAll("SELECT titulo, duracionMultix AS duracion, newIdMultix AS idMultix, thumbnail, temporada, c.nombre, c.idCategoria FROM grabaciones g 
			LEFT JOIN categorias c ON c.idCategoria = g.idCategoria 
			WHERE estatusWF = 6 AND newIdMultix <> '' AND g.baja = 0 AND g.videoteca = 1 AND now() > fechaDisponibilidad AND idGrabacion IN (
				SELECT idGrabacion FROM grabacionesSecciones WHERE seccion = ( SELECT idSeccion FROM secciones WHERE nombre = 'Infantil' ) AND baja = 0 )
			AND (titulo like '%$busqueda%' OR c.nombre like '%$busqueda%') AND  titulo not like '%demo%' AND titulo not like '%promo%' AND c.visibilidadInfantil = 1 AND c.portadaInfantil <> '' AND g.soloAudio = 0 
                ORDER BY temporada, titulo");
	echo json_encode($videos);
}

?>