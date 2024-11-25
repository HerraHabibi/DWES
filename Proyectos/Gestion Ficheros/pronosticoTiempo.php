<?php
// Archivo procesafile.php

// Cargar el archivo XML
$xmlFile = 'pronosticotiempoMadrid.xml'; // Cambia esto al nombre real del archivo XML
if (!file_exists($xmlFile)) {
    die("El archivo XML no se encontró.");
}

$xml = simplexml_load_file($xmlFile);
if (!$xml) {
    die("Error al cargar el archivo XML.");
}

// Mostrar el nombre de la localidad y otros datos generales
echo "<h1>Predicción meteorológica para: " . $xml->nombre . " (" . $xml->provincia . ")</h1>";
echo "<p>Fuente: " . $xml->origen->productor . " - <a href='" . $xml->origen->web . "'>Sitio web</a></p>";
echo "<hr>";

// Procesar cada día de predicción
foreach ($xml->prediccion->dia as $dia) {
    $fecha = (string) $dia['fecha'];
    echo "<h2>Predicción para el día: $fecha</h2>";

    // Probabilidad de precipitación por periodo horario
    echo "<h3>Probabilidad de precipitación</h3>";
    foreach ($dia->prob_precipitacion as $precipitacion) {
        $periodo = $precipitacion['periodo'] ? $precipitacion['periodo'] : "00-24";
        echo "Periodo: $periodo - Probabilidad: $precipitacion%<br>";
    }

    // Dirección y velocidad del viento por periodo horario
    echo "<h3>Dirección y velocidad del viento</h3>";
    foreach ($dia->viento as $viento) {
        $periodo = $viento['periodo'] ? $viento['periodo'] : "00-24";
        echo "Periodo: $periodo - Dirección: {$viento->direccion}, Velocidad: {$viento->velocidad} km/h<br>";
    }

    // Sensación térmica por periodo horario
    echo "<h3>Sensación térmica</h3>";
    foreach ($dia->sens_termica->dato as $sensTermica) {
        $hora = $sensTermica['hora'];
        echo "Hora: $hora - Sensación térmica: {$sensTermica}°C<br>";
    }

    // Temperatura máxima y mínima
    echo "<h3>Temperatura</h3>";
    echo "Máxima: {$dia->temperatura->maxima}°C, Mínima: {$dia->temperatura->minima}°C<br>";

    echo "<hr>";
}
?>
