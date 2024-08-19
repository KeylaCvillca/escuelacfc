<?php
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */

$this->title = 'Nuestra Ubicación';

// Incluir CSS de Leaflet
$this->registerCssFile('https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');

// Incluir JavaScript de Leaflet
$this->registerJsFile('https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', [
    'position' => View::POS_END, // POS_END asegura que el script se cargue al final de la página
]);

// JavaScript para inicializar el mapa con las coordenadas especificadas
$js = <<<JS
function initMap() {
    // Coordenadas en formato decimal
    var lat = 43.451389;
    var lng = -3.831250;

    // Inicializar el mapa centrado en las coordenadas especificadas
    var map = L.map('map').setView([lat, lng], 13);

    // Añadir capa de mapa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Añadir un marcador en las coordenadas especificadas
    L.marker([lat, lng]).addTo(map)
        .bindPopup('Escuela de Danza CFC - Polígono de Candina, c/ Nueve Valles,3')
        .openPopup();
}

// Llamar a la función para inicializar el mapa
initMap();
JS;
$this->registerJs($js, View::POS_END);
?>

<div class="site-location">
    <h1><?= Html::encode($this->title) ?></h1>
    <!-- Contenedor donde se renderizará el mapa -->
    <div id="map" style="height: 50vh; width: 30vw;"></div>
</div>
