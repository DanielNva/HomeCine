<?php
require '../controllers/config.php';
require '../controllers/buscarPelicula.php';
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/estilocrud.css">
    <title>CRUD de Películas</title>
</head>

<body>
    <!--Regresar al index-->
    <div id="regresar">
        <a href=".././index.php">Volver al incio</a>
    </div>

    <h1>Administración de Películas</h1>

    <!-- Botón para insertar películas desde la API -->
    <div id="acciones">
        <form action="crud/insertar.php" method="post">
            <input type="submit" value="Insertar Películas">
        </form>
    </div>

    <!-- Formulario para agregar una nueva película -->
    <h2>Agregar Nueva Película</h2>
    <form action="crud/crear.php" method="post" class="crear">
        <input type="text" name="title" placeholder="Título" required>
        <input type="text" name="poster_path" placeholder="Ruta del Póster" required>
        <input type="text" name="vote_average" placeholder="Valoración" required>
        <input type="submit" value="Agregar Película">
    </form>

    <!-- Lista de películas existentes con opciones de edición y eliminación -->
    <h2>Películas Existentes</h2>
    <div class="movie-container">
    <ul>
        <?php
        $db = $container->get('db')->getConnection();

        $sql = "SELECT id, title, poster_path, vote_average FROM peliculas";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="detalle-container">
                    <li>
                    <form action="crud/actualizar.php" method="post">
                        <input type="hidden" name="id" value="' . htmlspecialchars($row["id"]) . '">
                        <input type="text" name="title" value="' . htmlspecialchars($row["title"]) . '" required>
                        <p><img src="https://image.tmdb.org/t/p/w200/' . htmlspecialchars($row['poster_path']) . '" alt="' . htmlspecialchars($row['title']) . '"></p></a>
                        <input type="text" name="vote_average" value="' . htmlspecialchars($row["vote_average"]) . '" required>
                        <input type="submit" value="Actualizar" class="actualizar">
                    </form>
                    <form action="crud/eliminar.php" method="post" class="eliminar">
                        <input type="hidden" name="id" value="' . htmlspecialchars($row["id"]) . '">
                        <input type="submit" value="Eliminar" >
                    </form>
                </li>
                </div>';
            }
        } else {
            echo "<p>No se encontraron películas.</p>";
        }

        $db->close();
        ?>
    </ul>
    </div>
</body>

</html>