<?php
require 'conexion.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch($action) {
        case 'list':
            $stmt = $conn->query("SELECT * FROM personal_medico");
            $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($medicos);
            break;

        case 'especialidades':
            $stmt = $conn->query("SELECT DISTINCT especialidad FROM personal_medico");
            $especialidades = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo json_encode($especialidades);
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