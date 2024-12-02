<?php
include('dashboard.php'); // Incluimos el archivo dashboard.php que contiene solo la barra de navegación

include('includes/db.php'); // Incluimos la conexión a la base de datos

// Si el usuario ya está logueado, redirigirlo a index
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error_message = '';

// Si el formulario es enviado, verificamos el login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificamos si los campos no están vacíos
    if (empty($username) || empty($password)) {
        $error_message = "Todos los campos son obligatorios.";
    } else {
        // Comprobamos si el usuario existe en la base de datos
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si el usuario existe y la contraseña es correcta
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // Iniciamos la sesión
            header('Location: index.php'); // Redirigimos al index
            exit();
        } else {
            $error_message = "Credenciales incorrectas.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Enlaza el archivo CSS -->
</head>
<body>
    <div class="container login-container"> <!-- Cambia .login-container a .container -->
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST" onsubmit="return validateForm()">
            <input type="text" name="username" id="username" placeholder="Nombre de usuario" required>
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
            <div class="error" id="error-message"><?php echo $error_message; ?></div>
        </form>
        <div class="links">
            <a href="register.php">Registrarse</a>
        </div>
    </div>
    <script>
        function validateForm() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var errorMessage = document.getElementById('error-message');

            if (username === "" || password === "") {
                errorMessage.textContent = "Todos los campos son obligatorios.";
                return false;
            }

            if (password.length < 6) {
                errorMessage.textContent = "La contraseña debe tener al menos 6 caracteres.";
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
