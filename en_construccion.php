<?php

exit();
include("encabezado.php");
include ("funciones.php");

## PROMOS CLIP Y VIDEO
if (!isset($db)) $db=conecta();
$promos = $db->getRow("SELECT clipPromoKids, linkClipPromoKids, linkImagenPromoKids FROM configuraciones");

print_r($promos);

$clips = explode(",", $promos['clipPromoKids']);

print_r($clips);

echo $opcion = rand(1, count($clips));
echo $clipPromoKids = trim($clips[$opcion-1]);