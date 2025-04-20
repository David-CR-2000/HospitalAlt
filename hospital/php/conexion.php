<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Hospital_Alt";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Ocultar detalles técnicos en producción
    http_response_code(500);
    die("Error de conexión con la base de datos. Por favor, contacte al administrador.");
    // Registrar el error en un log (no mostrar al usuario)
    error_log('Error en conexion.php: ' . $e->getMessage());
}
?>