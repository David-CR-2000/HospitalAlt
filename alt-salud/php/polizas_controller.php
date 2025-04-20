<?php
header('Content-Type: application/json');
require 'conexion.php';

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

$action = isset($_GET['action']) ? sanitizeInput($_GET['action']) : '';

try {
    switch($action) {
        case 'get_plans':
            $plans = [
                ['name' => 'Básica', 'price' => 99],
                ['name' => 'Premium', 'price' => 299]
            ];
            echo json_encode($plans);
            break;

        case 'subscribe':
            $rawData = file_get_contents('php://input');
            $data = json_decode($rawData, true);
            
            // Validar datos
            if (!$data || !isset($data['plan']) || !isset($data['nombre']) || !isset($data['email'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Datos incompletos']);
                exit;
            }
            
            // Sanitizar datos
            $data = sanitizeInput($data);
            
            // Verificar CSRF token si viene de un formulario
            if (isset($data['csrf_token']) && !verifyCSRFToken($data['csrf_token'])) {
                http_response_code(403);
                echo json_encode(['error' => 'Token de seguridad inválido']);
                exit;
            }
            
            // Implementar lógica de suscripción con datos validados
            // Aquí iría el código para guardar la suscripción en la base de datos
            
            echo json_encode(['success' => true]);
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
    error_log('Error en polizas_controller.php: ' . $e->getMessage());
}
?>