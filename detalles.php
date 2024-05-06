<?php
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
    <title><?php echo $array["title"]; ?></title>
</head>

<body>
    <nav><a href="index.php">Volver</a></nav>
    <div class="pelicula">
        <h1><?php echo $array["title"]; ?></h1>
        <h2><?php echo $array["tagline"] ?></h2>
        <p>
            <img src="https://image.tmdb.org/t/p/w500/<?php echo $array['poster_path']; ?>" alt="">
            <?php echo $array["overview"] ?>
        </p>
        <ul>
            <?php
            foreach ($array['genres'] as $key => $value) {
                echo "<li>" . $value['name'] . "</li>";
            }
            ?>
        </ul>
        <p><a href="<?php echo $array["homepage"] ?>">Mas informacion</a></p>

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

        <?php
        echo "<pre>";
        print_r($array);
        ?>
    </div>
</body>

</html>