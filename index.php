<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilo.css">
    <title>HomeCine</title>
</head>

<body>
    <div class="container-top">    
        <a href="index.php">Inicio</a>
        <a href="CRUD/crud.php">CRUD</a>
    </div>

    <div id="busqueda">
        <form action="" method="get">
            <input type="text" name="q" placeholder="Buscar películas...">
            <input type="submit" value="Buscar">
        </form>
    </div>
    <div id="cartelera">
        <ul>
            <?php
            include "models/buscarPelicula.php";
            ?>
        </ul>
    </div>
</body>

</html>
