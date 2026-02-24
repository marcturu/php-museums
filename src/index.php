<?php
require_once "config/db_config.php";
require_once "includes/header.php";


/* Fetch two specific real museums with IDs 1 or 2 */
try {
    $stmt = $conn->query("SELECT id, nombre, ciudad, precio, imagen FROM museums_museos WHERE id IN (1,2)");
    $real_museums = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$real_museums) {
        die ("No se enucentran los museos con id 1 y 2 en la base de datos.");
    } 
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}

/* Fetch three random fake museums */
try {
    $stmt = $conn->query("SELECT id, nombre, ciudad, precio, imagen FROM museums_museos WHERE id NOT IN (1,2) ORDER BY RAND() LIMIT 3");
    $fake_museums = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$fake_museums) {
        die ("No se encuentran los museos ficitcios en la base de datos.");
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
    <meta name="description" content="Página de inicio de la web de museos.">
    <title>Directorio de Museos y Exposiciones filtrable - Home</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1 class="h1-home">Directorio de Museos y Exposiciones filtrable</h1>

    <?php if ($real_museums): ?>
        <div class="museums-row">
            <?php foreach($real_museums as $real_museum): ?>
                <div class="museum-card">
                    <img src="<?php echo htmlspecialchars($real_museum['imagen'] ?: 'assets/img/default.jpg'); ?>" alt="Imagen del <?php echo htmlspecialchars($real_museum['nombre']); ?>">
                    <p><a href="post.php?id=<?php echo $real_museum['id']; ?>"> <?php echo htmlspecialchars($real_museum['nombre']); ?></a></p>
                    <p><?php echo htmlspecialchars($real_museum['ciudad']); ?></p>
                    <p><?php echo htmlspecialchars($real_museum['precio']); ?> €</p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($fake_museums): ?>
        <div class="museums-row">
            <?php foreach($fake_museums as $fake_museum): ?>
                <div class="museum-card">
                    <img src="<?php echo htmlspecialchars($fake_museum['imagen'] ?: 'assets/img/default.jpg'); ?>" alt="Imagen del <?php echo htmlspecialchars($fake_museum['nombre']); ?>">
                    <p><a href="post.php?id=<?php echo $fake_museum['id']; ?>"> <?php echo htmlspecialchars($fake_museum['nombre']); ?></a></p>
                    <p><?php echo htmlspecialchars($fake_museum['ciudad']); ?></p>
                    <p><?php echo htmlspecialchars($fake_museum['precio']); ?> €</p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>
