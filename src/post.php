<?php
require_once "config/db_config.php";
require_once "includes/header.php";

if (!isset($_GET['id'])) die("ID del museo no especificado"); 
$id = (int)($_GET['id']);


try {
    $stmt = $conn->prepare("SELECT * FROM museums_museos WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $museum = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$museum) {
        die ("No se encuentra el museo con id ${id} en la base de datos.");
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
    <meta name="description" content="Página que muestra los detalles de un museo.">
    <title>Directorio de Museos y Exposiciones filtrable - <?php echo htmlspecialchars($museum['nombre']);?></title>
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