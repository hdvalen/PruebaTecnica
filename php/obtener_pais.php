<?php
$paises = ['Colombia', 'México', 'Argentina', 'España', 'Chile', 'Perú', 'Venezuela'];
header('Content-Type: application/json');
echo json_encode($paises);
?>
