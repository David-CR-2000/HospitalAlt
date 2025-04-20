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

// Generar token CSRF
function generateCSRFToken() {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verificar token CSRF
function verifyCSRFToken($token) {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

$action = isset($_GET['action']) ? sanitizeInput($_GET['action']) : (isset($_POST['action']) ? sanitizeInput($_POST['action']) : '');

try {
    switch($action) {
        case 'list':
            // Usar prepared statement incluso para consultas simples
            $stmt = $conn->prepare("SELECT * FROM personal_medico");
            $stmt->execute();
            $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($medicos);
            break;

        case 'especialidades':
            // Usar prepared statement incluso para consultas simples
            $stmt = $conn->prepare("SELECT DISTINCT especialidad FROM personal_medico");
            $stmt->execute();
            $especialidades = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo json_encode($especialidades);
            break;
            
        case 'csrf_token':
            // Generar token CSRF para formularios
            echo json_encode(['token' => generateCSRFToken()]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Acción no válida']);
    }
} catch(PDOException $e) {
    http_response_code(500);
    // Ocultar detalles técnicos en producción
    echo json_encode(['error' => 'Error en el servidor. Contacte al administrador']);
    // Registrar el error en un log (no mostrar al usuario)
    error_log('Error en medicos_controller.php: ' . $e->getMessage());
}
?>