<?php
require 'conexion.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

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
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $conn->prepare("INSERT INTO pacientes (nombre, apellido1, apellido2, DNI, TLF, num_poliza, datos_biometricos, estado, implante) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['nombre'],
                $data['apellido1'],
                $data['apellido2'],
                $data['dni'],
                $data['tlf'],
                $data['poliza'],
                $data['biometricos'],
                $data['estado'],
                $data['implante']
            ]);
            echo json_encode(['success' => true]);
            break;

        case 'update':
            // Actualizar paciente
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $conn->prepare("UPDATE pacientes SET 
                nombre = ?, apellido1 = ?, apellido2 = ?, 
                TLF = ?, num_poliza = ?, datos_biometricos = ?, 
                estado = ?, implante = ? 
                WHERE id_paciente = ?");
            $stmt->execute([
                $data['nombre'],
                $data['apellido1'],
                $data['apellido2'],
                $data['tlf'],
                $data['poliza'],
                $data['biometricos'],
                $data['estado'],
                $data['implante'],
                $data['id']
            ]);
            echo json_encode(['success' => true]);
            break;

        case 'delete':
            // Eliminar paciente
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM pacientes WHERE id_paciente = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Acción no válida']);
    }
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>