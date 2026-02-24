<?php 
session_start();
require_once "config/db_config.php";

/* Redirect if already logged in */
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$message = '';

/* Handle form submission */
if($_SERVER['REQUEST_METHOD'] === 'POST') { 

    /* Get form data */
    $username = trim($_POST['username'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    /* Validate input */
    if ($username === '' || $name === '' || $surname === '' || $password === '' || $password2 === '') {
        $message = 'Por favor, complete todos los campos.';
    } elseif ($password !== $password2) {
        $message = 'Las contraseñas no coinciden.';
    } else {
        
        /* Check if username already exists */
        $stmt = $conn->prepare("SELECT * FROM museums_users WHERE username = :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $message = 'El nombre de usuario ya existe.'; 
        } else {
            /* Hash the password */
            $safePassword = password_hash($password, PASSWORD_BCRYPT);
            
            /* Insert new user into database */
            $stmt = $conn->prepare("INSERT INTO museums_users (username, name, surname, password) VALUES (:username, :name, :surname, :password)");
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':surname', $surname);
            $stmt->bindValue(':password', $safePassword);
            if ($stmt->execute()) {
                $_SESSION['username'] = $username;
                header('Location: index.php'); // Redirect to homepage
                exit();
            } else {
                $message = 'Error al registrar el usuario. Por favor, inténtelo de nuevo.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de alta de usuario.">
    <title>Directorio de Museos y Exposiciones filtrable - Signup</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="signup-container">
        <h1>Signup</h1>
        <?php if ($message): ?> 
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Nombre de usuario:</label>
            <input type="text" name="username" required>

            <label>Nombre:</label>
            <input type="text" name="name" required>

            <label>Apellido:</label>
            <input type="text" name="surname" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>
           
            <label>Repetir contraseña:</label>
            <input type="password" name="password2" required>
            
            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>