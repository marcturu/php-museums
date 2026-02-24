<?php

require_once "../config/db_config.php";

header('Content-Type: application/json;');

try {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
    if ($page < 1) $page = 1;
    $limit = 10; // Museums per page
    $offset = ($page - 1) * $limit; // Calculate offset for SQL query

    $sql = "SELECT * FROM museums_museos ORDER BY id ASC LIMIT :limit OFFSET :offset";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $museums = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($museums);    
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error en la consulta: " . $e->getMessage()]);
    exit;
}
?>