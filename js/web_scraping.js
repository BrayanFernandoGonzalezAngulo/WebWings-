document.getElementById('scraping-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevenimos el envío del formulario para hacer la petición AJAX

    const formData = new FormData(this);

    fetch('generator.php', {  // Ruta al archivo PHP
        method: 'POST',
        body: formData
    })
    .then(response => response.json())  // Convertimos la respuesta a JSON
    .then(data => {
        const resultsDiv = document.getElementById('results');
        resultsDiv.innerHTML = '';  // Limpiamos resultados previos

        if (data.error) {
            // Si hay un error, lo mostramos
            resultsDiv.innerHTML = `<p>Error: ${data.error}</p>`;
        } else if (data.tags && data.tags.length > 0) {
            // Si encontramos etiquetas, las mostramos
            const tagsList = document.createElement('ul');
            data.tags.forEach(tag => {
                const listItem = document.createElement('li');
                listItem.textContent = tag;
                tagsList.appendChild(listItem);
            });
            resultsDiv.appendChild(tagsList);
        } else {
            resultsDiv.innerHTML = '<p>No se encontraron etiquetas.</p>';
        }
    })
    .catch(error => {
        // Manejo de errores de la solicitud
        const resultsDiv = document.getElementById('results');
        resultsDiv.innerHTML = `<p>Error al realizar la solicitud: ${error.message}</p>`;
    });
});
