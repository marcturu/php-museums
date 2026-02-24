<?php 
session_start();
require_once "config/db_config.php";

/* Make sure the user is logged in */
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$message = '';

/* Fetch current user data */
$stmt = $conn->prepare("SELECT * FROM museums_users WHERE username = :username");
$stmt->bindValue(':username', $_SESSION['username']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

/* Handle form submission */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* Get form data */
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    /* Validate input */
    if ($name === '' || $surname === '') {
        $message = 'Nombre y apellido son obligatorios.';
    } elseif ($password !== $password2) {
        $message = 'Las contraseñas no coinciden.';
    } else {

        if ($password) {
            /* Hash the new password */
            $safePassword = password_hash($password, PASSWORD_BCRYPT);
            /* Update user data including password */
            $stmt = $conn->prepare("UPDATE museums_users SET name = :name, surname = :surname, password = :password WHERE username = :username");
            $stmt->bindValue(':password', $safePassword);
        } else {
            /* Update user data without changing password */
            $stmt = $conn->prepare("UPDATE museums_users SET name = :name, surname = :surname WHERE username = :username");
        }

        /* Bind parameters */
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':surname', $surname); 
        $stmt->bindValue(':username', $_SESSION['username']);
        if ($stmt->execute()) {
            $message = 'Datos del perfil actualizados correctamente.';
        } else {
            $message = 'Error al actualizar los datos. Por favor, inténtelo de nuevo.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de edición del perfil del usuario.">
    <title>Directorio de Museos y Exposiciones filtrable - Editar perfil</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="edit-container">
        <h1>Editar perfil</h1>
        <?php if ($message): ?> 
            <p class="message <?php echo strpos($message, 'correctamente')!==false ? 'success' : 'error'; ?>"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="post">
            <p><strong>Nombre de usuario: <?php echo htmlspecialchars($user['username']); ?></strong></p>

            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']);?>" required>
            
            <label for="surname">Apellido:</label>
            <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($user['surname']);?>" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">
           
            <label for="password2">Repetir contraseña:</label>
            <input type="password" id="password2" name="password2">
            
            <button type="submit">Actualizar perfil</button>
        </form>
    </div>
</body>
</html>