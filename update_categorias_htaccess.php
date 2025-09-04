<?php
function updateHtaccess($nombre2, $id) {
    $result = array(
        'success' => false,
        'message' => '',
        'debug' => "=== Debug Log para tutorahkids.tv ===\n"
    );
    
    $result['debug'] .= "Recibidos - nombre2: '$nombre2', id: '$id'\n";
    
    $file = '.htaccess';
    $startMarker = "## INSERT DE PROGRAMAS START";
    $endMarker = "## INSERT DE PROGRAMAS END";
    $rule = "RewriteRule ^" . $nombre2 . "$ detalle-programa.php?idCategoria=$id\n";
    
    $result['debug'] .= "Regla a insertar: $rule\n";
    
    if (!file_exists($file)) {
        $result['message'] = 'Archivo .htaccess no encontrado';
        $result['debug'] .= "ERROR: El archivo .htaccess no existe en la ruta actual\n";
        return $result;
    }
    
    $result['debug'] .= "Archivo .htaccess encontrado\n";
    
    // Verificar permisos
    if (!is_readable($file)) {
        $result['message'] = 'Sin permisos de lectura para .htaccess';
        $result['debug'] .= "ERROR: No hay permisos de lectura para .htaccess\n";
        $result['debug'] .= "Permisos actuales: " . substr(sprintf('%o', fileperms($file)), -4) . "\n";
        return $result;
    }
    
    if (!is_writable($file)) {
        $result['message'] = 'Sin permisos de escritura para .htaccess';
        $result['debug'] .= "ERROR: No hay permisos de escritura para .htaccess\n";
        $result['debug'] .= "Permisos actuales: " . substr(sprintf('%o', fileperms($file)), -4) . "\n";
        return $result;
    }
    
    $content = file_get_contents($file);
    if ($content === false) {
        $result['message'] = 'No se pudo leer el archivo .htaccess';
        $result['debug'] .= "ERROR: file_get_contents falló al leer .htaccess\n";
        return $result;
    }
    
    $result['debug'] .= "Contenido del archivo leído correctamente (" . strlen($content) . " bytes)\n";
    
    $start = strpos($content, $startMarker);
    $end = strpos($content, $endMarker);
    
    if ($start === false || $end === false) {
        $result['message'] = 'Marcadores no encontrados en .htaccess';
        $result['debug'] .= "ERROR: No se encontraron los marcadores\n";
        $result['debug'] .= "Marcador inicio '" . $startMarker . "' encontrado: " . ($start !== false ? 'Sí' : 'No') . "\n";
        $result['debug'] .= "Marcador fin '" . $endMarker . "' encontrado: " . ($end !== false ? 'Sí' : 'No') . "\n";
        return $result;
    }
    
    $result['debug'] .= "Marcadores encontrados - Inicio: posición $start, Fin: posición $end\n";
    
    $section = substr($content, $start, $end - $start + strlen($endMarker));
    $result['debug'] .= "Sección extraída - Longitud: " . strlen($section) . " bytes\n";
    
    // Verificar si ya existe una regla para este ID
    $pattern = "/RewriteRule.*idCategoria=$id.*\n/";
    if (preg_match($pattern, $section, $matches)) {
        $result['debug'] .= "Se encontró una regla existente para ID $id: " . trim($matches[0]) . "\n";
        $result['debug'] .= "Reemplazando regla existente\n";
        
        $new_section = preg_replace($pattern, $rule, $section);
        $content = str_replace($section, $new_section, $content);
    } else {
        $result['debug'] .= "No se encontró regla existente para ID $id\n";
        $result['debug'] .= "Insertando nueva regla antes del marcador final\n";
        
        // Insertar nueva regla antes del marcador final
        $content = str_replace($endMarker, $rule . $endMarker, $content);
    }
    
    // Intentar escribir el archivo
    $writeResult = file_put_contents($file, $content);
    if ($writeResult === false) {
        $result['message'] = 'Error al escribir archivo .htaccess';
        $result['debug'] .= "ERROR: file_put_contents falló al escribir .htaccess\n";
        return $result;
    }
    
    $result['debug'] .= "Archivo actualizado correctamente (" . $writeResult . " bytes escritos)\n";
    $result['success'] = true;
    $result['message'] = 'Actualización exitosa';
    
    return $result;
}

// Verificar que se reciban los parámetros necesarios
$debug = "=== Log de recepción de parámetros ===\n";
$debug .= "Método de solicitud: " . $_SERVER['REQUEST_METHOD'] . "\n";
$debug .= "Parámetros recibidos:\n";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $debug .= "POST: " . print_r($_POST, true) . "\n";
} else {
    $debug .= "GET: " . print_r($_GET, true) . "\n";
}

// Capturar el cuerpo de la solicitud para depuración
$inputData = file_get_contents('php://input');
if ($inputData) {
    $debug .= "Cuerpo de la solicitud: " . $inputData . "\n";
}

if (isset($_POST['nombre2']) && isset($_POST['id'])) {
    $nombre2 = $_POST['nombre2'];
    $id = $_POST['id'];
    
    $result = updateHtaccess($nombre2, $id);
    $result['debug'] = $debug . "\n" . $result['debug'];
    
    echo json_encode($result);
} else {
    echo json_encode(array(
        'success' => false, 
        'message' => 'Parámetros faltantes: se requieren nombre2 e id',
        'debug' => $debug . "\nERROR: Parámetros nombre2 y/o id no recibidos"
    ));
}
?>