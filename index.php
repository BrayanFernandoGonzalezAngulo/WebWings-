<?php
include('dashboard.php'); // Incluimos el archivo dashboard.php que contiene solo la barra de navegación
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - WebWings+</title>
    <style>
        /* Estilo general */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Contenedor principal */
        .container, .about-us {
            text-align: center;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
        }

        .about-us h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .about-us p {
            text-align: justify;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <main>
        <div class="container">
            <h2>Bienvenido a WebWings+</h2>
            <p>Somos una plataforma de generación de etiquetas para videos de YouTube.</p>
            <p>Para comenzar, inicia sesión o regístrate si aún no tienes una cuenta.</p>
        </div>
        <div class="container">
            <h2>¿Quiénes somos?</h2>
            <p>WebWings+ es una plataforma diseñada para creadores de contenido en YouTube, ofreciendo herramientas para optimizar sus videos mediante etiquetas inteligentes. Nuestro objetivo es ayudar a los creadores a llegar a un público más amplio y a mejorar su visibilidad en línea.</p>
            <p>Con un equipo dedicado a la innovación y la tecnología, trabajamos continuamente para mejorar nuestras soluciones y adaptarnos a las necesidades de nuestros usuarios.</p>
            <p>Disclaimer: Esta pagina no tiene nada que ver con UpWeb.</p>
        </div>
    </main>
</body>
</html>
