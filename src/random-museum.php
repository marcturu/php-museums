<?php
require_once "config/db_config.php";
require_once "includes/header.php";

/* Fetch one random museum */
try {
    $stmt = $conn->query("SELECT * FROM museums_museos ORDER BY RAND() LIMIT 1");
    $museum = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$museum) {
        die ("No hay museos en la base de datos.");
    } 
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página que muestra un museo de manera aleatoria.">
    <title>Directorio de Museos y Exposiciones filtrable - Museo aleatorio</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="museum-container">
        <div class="museum-image">
            <img src="<?php echo htmlspecialchars($museum['imagen'] ?: 'assets/img/default.jpg'); ?>" alt="Imagen del <?php echo htmlspecialchars($museum['nombre']); ?>">
        </div>
        
        <div class="museum-details">
            <h1 class="museum-name">Nombre: <?php echo htmlspecialchars($museum['nombre']); ?> (<?php echo htmlspecialchars($museum['id']); ?>)</h1>
            <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($museum['ciudad']); ?></p>
            <p><strong>Temática:</strong> <?php echo htmlspecialchars($museum['tematica']); ?></p>
            <p><strong>Fechas y horarios:</strong> <?php echo htmlspecialchars($museum['fechas_horarios']); ?></p>
            <p><strong>Visitas guiadas:</strong> <?php echo htmlspecialchars($museum['visitas_guiadas']); ?></p>
            <p><strong>Precio:</strong> <?php echo htmlspecialchars($museum['precio']); ?> €</p>
        </div>
    </div>
</body>
</html>