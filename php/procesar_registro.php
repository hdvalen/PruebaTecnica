<?php
header('Content-Type: application/json');

function responder($status, $mensaje) {
  echo json_encode(['status' => $status, 'mensaje' => $mensaje]);
  exit;
}

// Validaciones de servidor
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  responder('error', 'Método no permitido.');
}

$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';
$confirmar = $_POST['confirmarContrasena'] ?? '';
$fechaNacimiento = $_POST['fechaNacimiento'] ?? '';
$genero = $_POST['genero'] ?? '';
$pais = $_POST['pais'] ?? '';
$terminos = isset($_POST['terminos']);

// Validaciones
if (strlen($nombre) < 3 || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
  responder('error', 'Nombre inválido.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  responder('error', 'Correo electrónico inválido.');
}

if ($contrasena !== $confirmar) {
  responder('error', 'Las contraseñas no coinciden.');
}

if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $contrasena)) {
  responder('error', 'La contraseña no cumple los requisitos.');
}

$edad = (int) ((time() - strtotime($fechaNacimiento)) / (365.25 * 24 * 60 * 60));
if ($edad < 18) {
  responder('error', 'Debes ser mayor de edad.');
}

if (!in_array($genero, ['Masculino', 'Femenino', 'Otro'])) {
  responder('error', 'Género inválido.');
}

if (!$terminos) {
  responder('error', 'Debes aceptar los términos.');
}

// CONEXIÓN A LA BASE DE DATOS
$mysqli = new mysqli('localhost', 'root', '', 'registro_usuarios');
if ($mysqli->connect_error) {
  responder('error', 'Error al conectar con la base de datos.');
}

// Validar email duplicado
$stmt = $mysqli->prepare('SELECT id FROM usuarios WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  responder('error', 'Este correo ya está registrado.');
}
$stmt->close();

// Guardar usuario
$hash = password_hash($contrasena, PASSWORD_DEFAULT);
$stmt = $mysqli->prepare('INSERT INTO usuarios (nombre, email, contrasena, fecha_nacimiento, genero, pais) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->bind_param('ssssss', $nombre, $email, $hash, $fechaNacimiento, $genero, $pais);

if ($stmt->execute()) {
  responder('success', 'Registro exitoso.');
} else {
  responder('error', 'Error al registrar.');
}
?>
