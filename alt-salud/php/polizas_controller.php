<?php
header('Content-Type: application/json');
require 'conexion.php';

$action = $_GET['action'] ?? '';

switch($action) {
    case 'get_plans':
        $plans = [
            ['name' => 'Básica', 'price' => 99],
            ['name' => 'Premium', 'price' => 299]
        ];
        echo json_encode($plans);
        break;

    case 'subscribe':
        $data = json_decode(file_get_contents('php://input'), true);
        // Implementar lógica de suscripción
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Acción no válida']);
}
?>