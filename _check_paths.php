<?php
header('Content-Type: text/plain; charset=utf-8');

echo "Verificando rutas y archivos:\n";
echo "Current directory: " . getcwd() . "\n";
echo "Script location: " . __FILE__ . "\n\n";

$htaccess = '.htaccess';
echo "Verificando .htaccess local:\n";
if (file_exists($htaccess)) {
    echo "- Existe: SÍ\n";
    echo "- Ruta absoluta: " . realpath($htaccess) . "\n";
    echo "- Permisos: " . substr(sprintf('%o', fileperms($htaccess)), -4) . "\n";
    echo "- Propietario: " . fileowner($htaccess) . "\n";
    echo "- Grupo: " . filegroup($htaccess) . "\n";
    echo "- ¿Se puede leer?: " . (is_readable($htaccess) ? "SÍ" : "NO") . "\n";
    echo "- ¿Se puede escribir?: " . (is_writable($htaccess) ? "SÍ" : "NO") . "\n";
} else {
    echo "- No se encontró el archivo .htaccess\n";
}