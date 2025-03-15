<?php
require 'conexion.php';

header('Content-Type: application/json');

try {
    $stmt = $conn->query("SELECT * FROM equipamiento_tecnologico");
    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($equipos);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>