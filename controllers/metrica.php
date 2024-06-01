<!-- metrics.php -->
<?php
include './bd/conexion.php';

// Medir el tiempo de inicio
$start = microtime(true);

// Número total de películas
$totalPeliculasSql = "SELECT COUNT(*) AS total FROM peliculas";
$totalPeliculasResult = $conn->query($totalPeliculasSql);
$totalPeliculas = $totalPeliculasResult->fetch_assoc()['total'];

// Medir el tiempo de fin y calcular la diferencia
$totalPeliculasTime = microtime(true) - $start;

// Medir el tiempo de inicio para la siguiente consulta
$start = microtime(true);

// Película con la mejor valoración
$mejorValoracionSql = "SELECT title, vote_average FROM peliculas ORDER BY vote_average DESC LIMIT 1";
$mejorValoracionResult = $conn->query($mejorValoracionSql);
$mejorValoracion = $mejorValoracionResult->fetch_assoc();

// Medir el tiempo de fin y calcular la diferencia
$mejorValoracionTime = microtime(true) - $start;

// Medir el tiempo de inicio para la siguiente consulta
$start = microtime(true);

// Película con la peor valoración
$peorValoracionSql = "SELECT title, vote_average FROM peliculas ORDER BY vote_average ASC LIMIT 1";
$peorValoracionResult = $conn->query($peorValoracionSql);
$peorValoracion = $peorValoracionResult->fetch_assoc();

// Medir el tiempo de fin y calcular la diferencia
$peorValoracionTime = microtime(true) - $start;

// Medir el tiempo de inicio para la siguiente consulta
$start = microtime(true);

// Valoración promedio de todas las películas
$promedioValoracionSql = "SELECT AVG(vote_average) AS promedio FROM peliculas";
$promedioValoracionResult = $conn->query($promedioValoracionSql);
$promedioValoracion = $promedioValoracionResult->fetch_assoc()['promedio'];

// Medir el tiempo de fin y calcular la diferencia
$promedioValoracionTime = microtime(true) - $start;

$conn->close();
?>