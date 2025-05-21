<?php
header('Content-Type: application/json');
require_once '../config.php';

function respuesta($estado, $mensaje) {
    echo json_encode(['status' => $estado, 'message' => $mensaje]);
    exit;
}

// Recibir datos
$nombre    = trim($_POST['nombre'] ?? '');
$correo    = trim($_POST['correo'] ?? '');
$clave     = $_POST['clave'] ?? '';
$confirmar = $_POST['confirmar_clave'] ?? '';
$nacimiento = $_POST['nacimiento'] ?? '';
$genero    = $_POST['genero'] ?? '';
$pais      = $_POST['pais'] ?? '';
$terminos  = isset($_POST['terminos']) ? 1 : 0;

// Validaciones
if (strlen($nombre) < 3 || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $nombre)) {
    respuesta('error', 'Nombre no válido');
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    respuesta('error', 'Correo inválido');
}
if (strlen($clave) < 8 || 
    !preg_match("/[A-Z]/", $clave) || 
    !preg_match("/[0-9]/", $clave) || 
    !preg_match("/[\W]/", $clave)) {
    respuesta('error', 'La contraseña no cumple los requisitos');
}
if ($clave !== $confirmar) {
    respuesta('error', 'Las contraseñas no coinciden');
}
if (!$terminos) {
    respuesta('error', 'Debes aceptar los términos y condiciones');
}

// Validar edad
$fechaHoy = new DateTime();
$fechaNac = new DateTime($nacimiento);
$edad = $fechaHoy->diff($fechaNac)->y;
if ($edad < 18) {
    respuesta('error', 'Debes ser mayor de edad');
}

// Validar correo duplicado
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->execute([$correo]);
if ($stmt->fetch()) {
    respuesta('error', 'El correo ya está registrado');
}

// Guardar en BD
$hash = password_hash($clave, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, clave, nacimiento, genero, pais) VALUES (?, ?, ?, ?, ?, ?)");
try {
    $stmt->execute([$nombre, $correo, $hash, $nacimiento, $genero, $pais]);
    respuesta('success', 'Usuario registrado exitosamente');
} catch (PDOException $e) {
    respuesta('error', 'Error al guardar los datos');
}
