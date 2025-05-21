<?php
$host = 'localhost';
$db   = 'pruebaTecnica';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Error al conectar con la base de datos'
    ]));
}
?>
