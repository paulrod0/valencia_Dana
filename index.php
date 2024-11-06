<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Valencia Ayuda</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" crossorigin=""/>
    <!-- Tu archivo CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1><a href="index.php">Valencia Ayuda</a></h1>
        <nav>
            <a href="add_marker.php">Agregar Marcador</a>
        </nav>
    </header>
    <main>
        <h2>Mapa Interactivo</h2>
        <div id="map" style="height: 500px;"></div>
    </main>
    <footer>
        <p>&copy; 2023 Valencia Ayuda</p>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" crossorigin=""></script>
    <!-- Obtener marcadores desde el backend -->
    <script src="get_markers.php"></script>
    <script>
        // Inicializar el mapa
        var map = L.map('map').setView([39.4699, -0.3763], 13); // Valencia

        // Añadir capa de mapa
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Función para obtener el ícono según la categoría
        function getIcon(category) {
            var iconUrl;
            switch(category) {
                case 'missing_person':
                    iconUrl = 'assets/icons/missing_person.png';
                    break;
                case 'help_center':
                    iconUrl = 'assets/icons/help_center.png';
                    break;
                case 'hazard_zone':
                    iconUrl = 'assets/icons/hazard_zone.png';
                    break;
                default:
                    iconUrl = 'assets/icons/default.png';
            }
            return L.icon({
                iconUrl: iconUrl,
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });
        }

        // Añadir marcadores al mapa
        markers.forEach(function(marker) {
            L.marker([marker.latitude, marker.longitude], {icon: getIcon(marker.category)})
                .addTo(map)
                .bindPopup('<b>' + marker.title + '</b><br>' + marker.description +
                           (marker.contact_info ? '<br>Contacto: ' + marker.contact_info : ''));
        });
    </script>
</body>
</html>
