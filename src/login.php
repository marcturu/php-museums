<?php 
session_start();
require_once "config/db_config.php";

$message = '';

/* Handle form submission */
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* Get form data */
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    /* Validate input */
    if ($username === '' || $password === '') {
        $message = 'Por favor, complete todos los campos.';
    } else {

        /* Fetch user from database */
        $stmt = $conn->prepare("SELECT * FROM museums_users WHERE username = :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        /* Verify user existence and password validation */
        if ($user && password_verify($password, $user['password'])) {
            /* Successful login */
            $_SESSION['username'] = $user['username'];
            header('Location: index.php'); // Redirect to homepage
            exit();
        } else {
            $message = 'Nombre de usuario o contraseña incorrectos.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de inicio de sesión.">
    <title>Directorio de Museos y Exposiciones filtrable - Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php if ($message): ?> 
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Nombre de usuario:</label>
            <input type="text" name="username" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Iniciar sesión</button>
        </form> 
    </div>
</body>
</html>