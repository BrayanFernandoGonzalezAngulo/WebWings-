<?php
include('dashboard.php'); // Incluimos el archivo dashboard.php que contiene solo la barra de navegación

include('includes/db.php'); // Incluimos la conexión a la base de datos

$error_message = '';

// Si el formulario es enviado, verificamos el registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Verificamos si los campos no están vacíos
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "Todos los campos son obligatorios.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Las contraseñas no coinciden.";
    } elseif (strlen($password) < 6) {
        $error_message = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        // Verificamos si el nombre de usuario ya existe
        $query = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $error_message = "El nombre de usuario o el correo electrónico ya están en uso.";
        } else {
            // Hasheamos la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insertamos el nuevo usuario en la base de datos
            $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);

            if ($stmt->execute()) {
                // Iniciamos la sesión del usuario
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;

                // Redirigimos al index después de un registro exitoso
                header('Location: index.php');
                exit();
            } else {
                $error_message = "Hubo un error al registrar el usuario. Inténtalo de nuevo.";
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
    <title>Registro</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Enlaza el archivo CSS -->
</head>
<body>
    <div class="container register-container"> <!-- Cambia .register-container a .container -->
        <h2>Registro</h2>
        <form action="register.php" method="POST" onsubmit="return validateForm()">
            <input type="text" id="username" name="username" placeholder="Nombre de usuario" required>
            <input type="email" id="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmar contraseña" required>
            <button type="submit">Registrarse</button>
            <div class="error" id="error-message"><?php echo $error_message; ?></div>
        </form>
        <div class="links">
            <a href="login.php">Iniciar Sesión</a>
        </div>
    </div>
    <script>
        function validateForm() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm-password').value;
            var errorMessage = document.getElementById('error-message');

            if (password !== confirmPassword) {
                errorMessage.textContent = "Las contraseñas no coinciden.";
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
