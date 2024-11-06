<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Marcador - Valencia Ayuda</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" crossorigin=""/>
    <!-- Tu archivo CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1><a href="index.php">Valencia Ayuda</a></h1>
        <nav>
            <a href="index.php">Inicio</a>
        </nav>
    </header>
    <main>
        <h2>Agregar Nuevo Marcador</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $category = $_POST['category'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];
            $contact_info = $_POST['contact_info'];

            $stmt = $conn->prepare("INSERT INTO markers (category, title, description, latitude, longitude, contact_info) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdds", $category, $title, $description, $latitude, $longitude, $contact_info);

            if ($stmt->execute()) {
                echo "<p>Marcador agregado exitosamente. <a href='index.php'>Ver en el mapa</a></p>";
            } else {
                echo "<p>Error al agregar el marcador: " . $stmt->error . "</p>";
            }
            $stmt->close();
            $conn->close();
        } else {
        ?>
        <form method="post">
            <label for="category">Categoría:</label>
            <select name="category" id="category" required>
                <option value="missing_person">Persona Desaparecida</option>
                <option value="help_center">Centro de Ayuda</option>
                <option value="hazard_zone">Zona de Peligro</option>
            </select><br><br>

            <label for="title">Título:</label>
            <input type="text" name="title" id="title" required><br><br>

            <label for="description">Descripción:</label>
            <textarea name="description" id="description"></textarea><br><br>

            <label for="contact_info">Información de Contacto:</label>
            <input type="text" name="contact_info" id="contact_info"><br><br>

            <input type="hidden" name="latitude" id="latitude" required>
            <input type="hidden" name="longitude" id="longitude" required>

            <p>Haz clic en el mapa para seleccionar la ubicación:</p>
            <div id="map" style="height: 400px;"></div><br>

            <button type="submit">Guardar Marcador</button>
        </form>
        <?php } ?>
    </main>
    <footer>
        <p>&copy; 2023 Valencia Ayuda</p>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" crossorigin=""></script>
    <script>
        // Inicializar el mapa
        var map = L.map('map').setView([39.4699, -0.3763], 13);

        // Añadir capa de mapa
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        function onMapClick(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            // Asignar latitud y longitud a los campos ocultos del formulario
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        }

        map.on('click', onMapClick);
    </script>
</body>
</html>
