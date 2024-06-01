<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métricas de Películas</title>
</head>
<body>
    <?php include './controllers/metrica.php'?>
    <h1>Métricas de Películas</h1>
    <ul>
        <li>Número total de películas: <?php echo $totalPeliculas; ?> (Consultado en <?php echo number_format($totalPeliculasTime, 5); ?> segundos)</li>
        <li>Película con la mejor valoración: <?php echo htmlspecialchars($mejorValoracion['title']) . " (" . $mejorValoracion['vote_average'] . ")"; ?> (Consultado en <?php echo number_format($mejorValoracionTime, 5); ?> segundos)</li>
        <li>Película con la peor valoración: <?php echo htmlspecialchars($peorValoracion['title']) . " (" . $peorValoracion['vote_average'] . ")"; ?> (Consultado en <?php echo number_format($peorValoracionTime, 5); ?> segundos)</li>
        <li>Valoración promedio de todas las películas: <?php echo number_format($promedioValoracion, 1); ?> (Consultado en <?php echo number_format($promedioValoracionTime, 5); ?> segundos)</li>
    </ul>
</body>
</html>
