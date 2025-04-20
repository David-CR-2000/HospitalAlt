<?php
require 'conexion.php';

header('Content-Type: application/json');

// Función para validar y sanitizar datos
function sanitizeInput($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitizeInput($value);
        }
    } else {
        $data = htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    return $data;
}

try {
    // Usar prepared statement incluso para consultas simples
    $stmt = $conn->prepare("SELECT * FROM equipamiento_tecnologico");
    $stmt->execute();
    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($equipos);
} catch(PDOException $e) {
    http_response_code(500);
    // Ocultar detalles técnicos en producción
    echo json_encode(['error' => 'Error en el servidor. Contacte al administrador']);
    // Registrar el error en un log (no mostrar al usuario)
    error_log('Error en equipos_controller.php: ' . $e->getMessage());
}
?>