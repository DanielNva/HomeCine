<?php
session_start();
$_SESSION["n1"] = rand(1, 9);
$_SESSION["n2"] = rand(1, 9);

if (isset($_GET['id']) && is_numeric(($_GET['id']))) {
    $id = $_GET['id'];
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.themoviedb.org/3/movie/' . $id . '?append_to_response=videos&language=es');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJmYzlhYjI1N2IzNmE4ZDU1NTdkYzVkZWY3ZjZlNWVhMSIsInN1YiI6IjY2Mzc4MWFmMmEwOWJjMDEyNjVhMTk0NiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.fgL4pQj017Ka9Q0RBKssU2OcYAlggybLFxNXOAoHCZ4';
    $headers[] = 'Accept: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $array = json_decode($result, true);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilo.css">
    <title><?php echo $array["title"]; ?></title>
</head>

<body>
    <nav><a href="index.php">Volver</a></nav>
    <div class="pelicula">
        <section id="general">
            <div class="deta">
                <h1><?php echo $array["title"]; ?></h1>
                <h2><?php echo $array["tagline"]; ?></h2>
                <ul>
                    <?php
                    foreach ($array['genres'] as $key => $value) {
                        echo "<li>" . $value['name'] . "</li>";
                    }
                    ?>
                </ul>
                <p><a href="<?php echo $array["homepage"]; ?>">Mas informacion</a></p>
                <p>
                    <?php echo $array["overview"]; ?>
                </p>
            </div>
            <div>
                <img src="https://image.tmdb.org/t/p/w500/<?php echo $array['poster_path']; ?>" alt="">
            </div>
        </section>
    </div>
    <div>
        <h2>Comentarios sobre la pelicula <?php echo $array["title"]; ?></h2>
    </div>
    <form action="SaveComment.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <textarea name="comentario" placeholder="Comentarios ..." required></textarea>
        <input type="text" name="nombre" placeholder="Su Nombre: ">
        <input type="email" name="mail" placeholder="Su Correo: ">
        <input type="number" name="seguridad" placeholder="<?php echo $_SESSION["n1"] . " + " . $_SESSION["n2"] ?>" required>
        <button type="submit">Enviar</button>
    </form>
    <ul id="comentarios">
        <?php
        $comentarios = [];
        $ruta = "./comentarios/{$_GET['id']}.txt";
        if (file_exists($ruta)) {
            $comentarios = unserialize(file_get_contents($ruta));
        }
        if ($comentarios != "" && count($comentarios)) {
            foreach ($comentarios as $key => $value) {
                echo "<li><p>{$value[0]}</p><p><strong>{$value[1]}</strong>, {$value[3]}</p></li>";
            }
        }
        ?>
    </ul>
    <h2>Videos</h2>
    <ul id="video">
        <?php
        if (isset($array['videos']['results']) > 0) {
            foreach ($array['videos']['results'] as $key => $value) {
                if ($value['site'] == "YouTube") {
                    echo "<li><h3>" . $value['name'] . "</h3>";
        ?>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $value['key'] ?>" title="<?php echo $value['name'] ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <?php
                    echo "</li>";
                }
            }
        }
        ?>
    </ul>
    </div>
</body>

</html>
<script src="JS/video.js"></script>