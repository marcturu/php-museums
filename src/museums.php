<?php
require_once "config/db_config.php";
require_once "includes/header.php";

try {
    /* Sorting and filtering variables */
    $order = null;
    $hasOrder = false;
    if (isset($_GET['order']) && in_array(strtolower($_GET['order']), ['asc', 'desc'])) {
        $order = strtoupper($_GET['order']);
        $hasOrder = true;
    }

    /* Validate theme filter */
    $allowedThemes = ['Arte', 'Familia', 'Historia', 'Tecnología', 'Temporal', 'Tradición'];
    $theme = (isset($_GET['theme']) && in_array($_GET['theme'], $allowedThemes)) ? $_GET['theme'] : null;

    /* Determine if pagination is needed */
    $needPagination = !$hasOrder && !$theme;

    /* Build base SQL query */
    $sqlBase = "SELECT id, nombre, ciudad, precio, imagen FROM museums_museos";

    /* Add WHERE clause if filtering by theme is requested */
    if ($theme) {
        $sqlBase .= " WHERE tematica = :theme";
    }
    /* Add ORDER BY clause if sorting is requested */
    if ($hasOrder) {
        $sqlBase .= " ORDER BY precio $order";
    } else {
        $sqlBase .= " ORDER BY id ASC";
    }

    /* Pagination logic only if filters not applied */
    if ($needPagination) {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
        $page = max(1, $page);

        $limit = 5; // Museums per page
        $offset = ($page - 1) * $limit; // Calculate offset for SQL query
        $sqlBase .= " LIMIT :limit OFFSET :offset";

        $stmtCount = $conn->query("SELECT count(*) FROM museums_museos");
        $totalPages = ceil($stmtCount->fetchColumn() / $limit);
        
    }

    $stmt = $conn->prepare($sqlBase);

    /* Bind parameters if they need to be used in the SQL query */
    if ($theme) {
        $stmt->bindValue(':theme', $theme, PDO::PARAM_STR);
    }
    if ($needPagination) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    }

    /* Execute the query and fetch results */
    $stmt->execute();
    $museums = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página que muestra un listado de museos con paginación.">
    <title>Directorio de Museos y Exposiciones filtrable - Museos</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

    <!-- Filter Bar -->
    <form class="filter-bar" method="get" action="museums.php">
        <div class="filter-group">
            <label for="order">Ordenar por precio:</label>
            <select name="order" id="order">
                <option value="" <?php if (!$hasOrder) echo 'selected'; ?>>Sin orden</option>
                <option value="asc" <?php if ($hasOrder && $order === 'ASC') echo 'selected'; ?>>Ascendente</option>
                <option value="desc" <?php if ($hasOrder && $order === 'DESC') echo 'selected'; ?>>Descendente</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="theme">Filtrar por temática:</label>
            <select name="theme" id="theme">
                <option value="" <?php if (!$theme) echo 'selected'; ?>>Todas</option>
                <option value="Arte" <?php if ($theme === 'Arte') echo 'selected'; ?>>Arte</option>
                <option value="Familia" <?php if ($theme === 'Familia') echo 'selected'; ?>>Familia</option>
                <option value="Historia" <?php if ($theme === 'Historia') echo 'selected'; ?>>Historia</option>
                <option value="Tecnología" <?php if ($theme === 'Tecnología') echo 'selected'; ?>>Tecnología</option>
                <option value="Temporal" <?php if ($theme === 'Temporal') echo 'selected'; ?>>Temporal</option>
                <option value="Tradición" <?php if ($theme === 'Tradición') echo 'selected'; ?>>Tradición</option>
            </select>
        </div>

        <button type="submit">Aplicar filtros</button>
        <a href="museums.php" class="clear-filters">Limpiar filtros</a>
    </form>

    <!-- Museum List -->
    <div class="museums-list">
    <?php foreach($museums as $museum): ?>
        <article class="museum-row">
            <div class="museum-row-image">
                <img src="<?php echo htmlspecialchars($museum['imagen']); ?>" alt="Imagen del museo">
            </div>
            <div class="museum-row-info">
                <h2>
                    <a href="post.php?id=<?php echo $museum['id']; ?>"><?php echo htmlspecialchars($museum['nombre']); ?> </a>
                </h2>
                <p><?php echo htmlspecialchars($museum['ciudad']); ?></p>
                <p><?php echo htmlspecialchars($museum['precio']); ?> €</p>
            </div>
        </article>
    <?php endforeach; ?>
    </div>

    <!-- Pagination Links -->
    <?php if ($needPagination): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="<?php echo ($i === $page) ? 'active' : '' ?>" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</body>
</html>