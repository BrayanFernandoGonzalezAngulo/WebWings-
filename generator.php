<?php
// Incluimos la librería simple_html_dom
require 'includes/simple_html_dom.php';  // Asegúrate de que el archivo esté en la ubicación correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $youtubeUrl = trim($_POST['youtube_url']);

    // Validar que la URL corresponde a YouTube
    if (empty($youtubeUrl)) {
        echo json_encode(['error' => 'La URL no puede estar vacía.']);
        exit;
    }

    if (!filter_var($youtubeUrl, FILTER_VALIDATE_URL)) {
        echo json_encode(['error' => 'La URL no es válida.']);
        exit;
    }

    if (strpos($youtubeUrl, 'youtube.com') === false) {
        echo json_encode(['error' => 'La URL no pertenece a YouTube.']);
        exit;
    }

    try {
        // Obtener el contenido HTML del video de YouTube
        $html = @file_get_html($youtubeUrl);  // Usamos @ para evitar mostrar errores de PHP por sí mismos

        if (!$html) {
            throw new Exception('No se pudo obtener el contenido de la URL.');
        }

        // Obtener las etiquetas del video (se encuentran en la metaetiqueta "keywords" o en los datos de la página)
        $metaTags = $html->find('meta[name=keywords]', 0); // Buscamos la etiqueta <meta name="keywords">
        if ($metaTags) {
            $tags = explode(',', $metaTags->content);  // Separamos las etiquetas por coma
            $tags = array_map('trim', $tags);  // Eliminamos espacios en blanco
            echo json_encode(['tags' => $tags]);
        } else {
            echo json_encode(['error' => 'No se encontraron etiquetas en el video.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

include('dashboard.php'); // Incluimos el archivo dashboard.php que contiene solo la barra de navegación
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Etiquetas</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/web_scraping.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 150px; /* Ajusta este valor según la altura de tu barra de navegación */
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input[type="url"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        #results {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<main>
    <div class="container">
        <h2>Generador de Etiquetas</h2>
        <form id="scraping-form">
            <input type="url" name="youtube_url" placeholder="Ingresa el URL del video de YouTube" required>
            <button type="submit">Generar Etiquetas</button>
        </form>
        <div id="results"></div>
    </div>
</main>
<script>
document.getElementById('scraping-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    const response = await fetch('generator.php', {
        method: 'POST',
        body: formData
    });
    const result = await response.json();
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '';

    if (result.error) {
        resultsDiv.innerHTML = `<p>${result.error}</p>`;
    } else {
        const tags = result.tags;
        const listGroup = document.createElement('ul');
        listGroup.className = 'list-group';
        tags.forEach(tag => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.textContent = tag;
            listGroup.appendChild(listItem);
        });

        const textArea1 = document.createElement('textarea');
        textArea1.className = 'form-control tags-in-textarea';
        textArea1.rows = 8;
        textArea1.textContent = tags.join('\n');

        const textArea2 = document.createElement('textarea');
        textArea2.className = 'form-control tags-in-textarea';
        textArea2.rows = 8;
        textArea2.textContent = tags.join(', ');

        resultsDiv.appendChild(listGroup);
        resultsDiv.appendChild(textArea1);
        resultsDiv.appendChild(document.createElement('br'));
        resultsDiv.appendChild(textArea2);
    }
});
</script>
</body>
</html>