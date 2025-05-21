<?php
// Simulación de datos desde PHP (puedes luego cargar desde DB si prefieres)
$paises = ["Argentina", "Colombia", "Chile", "México", "Perú", "Venezuela", "Ecuador", "España", "Estados Unidos"];

header('Content-Type: application/json');
echo json_encode($paises);
