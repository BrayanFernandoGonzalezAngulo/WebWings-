<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #333;
            color: white;
        }
        .navbar h1 {
            display: flex;
            align-items: center;
        }
        .navbar h1 img {
            margin-right: 10px;
        }
        .navbar nav {
            display: flex;
            gap: 15px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

<!-- Barra de navegación -->
<div class="navbar">
    <h1>
        <img src="uploads/logo.png" alt="Logo" width="50" height="50">
        WebWings+
    </h1>
    <nav>
        <!-- Enlaces de navegación: Cambian según el estado de sesión -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php">Inicio</a>
            <a href="generator.php">Generador de Etiquetas</a>
            <a href="logout.php">Cerrar Sesión</a>
        <?php else: ?>
            <a href="index.php">Inicio</a>
            <a href="login.php">Iniciar Sesión</a>
            <a href="register.php">Registrarse</a>
        <?php endif; ?>
    </nav>
</div>
</body>
</html>
