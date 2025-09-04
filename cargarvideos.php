<?php
include ("funciones.php");
if(!isset($db)){
    $db=conecta();    
}
$accion = $_POST['accion'];

if($accion == 'cargarvideos'){
    $id = limpia_numero($_POST['id']);

    $ordenMaterial = $db->getOne("SELECT ordenMaterialInfantil FROM categorias WHERE idCategoria = ?", array($id));
    $orden = $ordenMaterialPaginaInstruccion[$ordenMaterial];

$temporadasTxt = " CASE ";
foreach ($temporadas as $key => $value)
    $temporadasTxt .= " WHEN temporada=$key THEN '$value' ";
$temporadasTxt .= " END AS temporada2";

    $material=$db->getAll("
        SELECT
            titulo,
            duracionMultix AS duracion,
            newIdMultix AS idMultix,
            thumbnail,
            temporada,
            $temporadasTxt
        FROM
            grabaciones g
        LEFT JOIN
            categorias c ON c.idCategoria = g.idCategoria
        WHERE
            estatusWF = 6
            AND newIdMultix <> ''
            AND g.baja = 0
            AND g.videoteca = 1
            AND now() > fechaDisponibilidad
            AND idGrabacion IN (SELECT idGrabacion FROM grabacionesSecciones WHERE seccion = ( SELECT idSeccion FROM secciones WHERE nombre = 'Infantil' ) AND baja = 0 )
            AND c.idCategoria = ?
            AND temporada <> 0
        ORDER BY
            temporada2,
            $orden", array($id));

    echo json_encode($material);
}

if($accion == 'cargarvideos2'){
    $id = limpia_numero($_POST['id']);
    $temporadas=$db->getOne("SELECT count(temporada) FROM grabaciones g LEFT JOIN categorias c ON c.idCategoria = g.idCategoria WHERE estatusWF = 6 AND newIdMultix <> '' AND g.baja = 0 AND g.videoteca = 1 AND now() > fechaDisponibilidad AND idGrabacion IN (SELECT idGrabacion FROM grabacionesSecciones WHERE seccion = ( SELECT idSeccion FROM secciones WHERE nombre = 'Infantil' ) AND baja = 0 ) AND c.idCategoria = ? and temporada <> 0 ORDER BY temporada, titulo",Array($id));
    $numTemporadas = cuenta($temporadas);

    $material=$db->getAll("SELECT titulo, duracionMultix AS duracion, newIdMultix AS idMultix, thumbnail, temporada FROM grabaciones g LEFT JOIN categorias c ON c.idCategoria = g.idCategoria WHERE estatusWF = 6 AND newIdMultix <> '' AND g.baja = 0 AND g.videoteca = 1 AND now() > fechaDisponibilidad AND idGrabacion IN (SELECT idGrabacion FROM grabacionesSecciones WHERE seccion = ( SELECT idSeccion FROM secciones WHERE nombre = 'Infantil' ) AND baja = 0 ) AND c.idCategoria = ? and temporada <> 0 ORDER BY temporada, titulo",Array($id));

    $response = array();
    $response['numTemporadas'] = $numerotemporadas;
    $response['videos'] = $material;
    echo json_encode($response);
}

?>