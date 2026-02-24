<?php 
require_once "../config/db_config.php";

header('Content-Type: application/json;');

try {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "ID del museo no especificado"]);
        exit;
    }

    $id = (int)($_GET['id']);

    $sql = "SELECT * FROM museums_museos WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $museums = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$museums) {
        http_response_code(404);
        echo json_encode(["error" => "No se encuentra el museo con id ${id} en la base de datos."]);
        exit;
    }
    
    echo json_encode($museums);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error en la consulta: " . $e->getMessage()]);
    exit;
}
?>