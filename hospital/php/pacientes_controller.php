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
            // Obtener pacientes
            $stmt = $conn->query("SELECT * FROM pacientes LIMIT 50");
            $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($pacientes);
            break;

        case 'create':
            // Crear nuevo paciente
            $rawData = file_get_contents('php://input');
            $data = json_decode($rawData, true);
            
            // Validar datos
            if (!$data || !isset($data['nombre']) || !isset($data['apellido1']) || !isset($data['dni'])) {
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
            
            $stmt = $conn->prepare("INSERT INTO pacientes (nombre, apellido1, apellido2, DNI, TLF, num_poliza, datos_biometricos, estado, implante) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['nombre'],
                $data['apellido1'],
                $data['apellido2'] ?? '',
                $data['dni'],
                $data['tlf'] ?? '',
                $data['poliza'] ?? '',
                $data['biometricos'] ?? '',
                $data['estado'] ?? '',
                $data['implante'] ?? ''
            ]);
            echo json_encode(['success' => true]);
            break;

        case 'update':
            // Actualizar paciente
            $rawData = file_get_contents('php://input');
            $data = json_decode($rawData, true);
            
            // Validar datos
            if (!$data || !isset($data['id']) || !is_numeric($data['id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID de paciente inválido']);
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
            
            $stmt = $conn->prepare("UPDATE pacientes SET 
                nombre = ?, apellido1 = ?, apellido2 = ?, 
                TLF = ?, num_poliza = ?, datos_biometricos = ?, 
                estado = ?, implante = ? 
                WHERE id_paciente = ?");
            $stmt->execute([
                $data['nombre'] ?? '',
                $data['apellido1'] ?? '',
                $data['apellido2'] ?? '',
                $data['tlf'] ?? '',
                $data['poliza'] ?? '',
                $data['biometricos'] ?? '',
                $data['estado'] ?? '',
                $data['implante'] ?? '',
                $data['id']
            ]);
            echo json_encode(['success' => true]);
            break;

        case 'delete':
            // Eliminar paciente
            $id = isset($_POST['id']) ? sanitizeInput($_POST['id']) : null;
            
            // Validar ID
            if (!$id || !is_numeric($id)) {
                http_response_code(400);
                echo json_encode(['error' => 'ID de paciente inválido']);
                exit;
            }
            
            // Verificar CSRF token
            if (isset($_POST['csrf_token']) && !verifyCSRFToken($_POST['csrf_token'])) {
                http_response_code(403);
                echo json_encode(['error' => 'Token de seguridad inválido']);
                exit;
            }
            
            $stmt = $conn->prepare("DELETE FROM pacientes WHERE id_paciente = ?");
            $stmt->execute([$id]);
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
    error_log('Error en pacientes_controller.php: ' . $e->getMessage());
}
?>