<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* Get current page name */
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="menu-nav">
    <ul class="menu-nav-list">
        <!-- Basic navigation links -->
        <li><a href="index.php" class="<?php echo ($current_page === 'index.php') ? 'active' : ''; ?>">Home</a></li>
        <li><a href="random-museum.php" class="<?php echo ($current_page === 'random-museum.php') ? 'active' : ''; ?>">Museo aleatorio</a></li>
        <li><a href="museums.php" class="<?php echo ($current_page === 'museums.php') ? 'active' : ''; ?>">Museos</a></li>

        <!-- APIs -->
        <li class="menu-nav-api">
            <span>API_museums</span>
            <input type="number" id="museumsPage" min="1" value="1">
            <button type="button" onclick="window.open('api/museums/' + document.getElementById('museumsPage').value, '_blank')">Abrir</button>
        </li> 
        <li class="menu-nav-api">
            <span>API_museum</span>
            <input type="number" id="museumId" name="id" min="1" value="1">
            <button type="button" onclick="window.open('api/museum/' + document.getElementById('museumId').value, '_blank')">Abrir</button>
        </li>
    </ul>

    <div class="menu-user">
        <div class="menu-buttons">
            <!-- User not logged in -->
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="login.php">Login</a>
                <a href="signup.php">Signup</a>

            <!-- User logged in -->
            <?php else: ?>
                <a href="edit.php">Perfil de usuario</a>
                <a class="logout" href="logout.php">Logout</a>
            <?php endif; ?> 
        </div>
        <?php if (isset($_SESSION['username'])): ?>
            <span class="menu-nav-user">Contento de volverte a ver, <strong><?php echo htmlspecialchars($_SESSION['username']) ?></strong> !</span>
        <?php endif; ?>
    </div>
</nav>