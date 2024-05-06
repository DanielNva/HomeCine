<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeCine</title>
</head>

<body>
    <div id="cartelera">
        <?php

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.themoviedb.org/3/movie/now_playing?language=es&page=1&region=CO');
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
        /* echo "<pre>";
        print_r($array); */

        echo "<ul>";
        foreach ($array['results'] as $key => $value) {
            echo '<li>
                <a href="detalles.php?id=' . $value["id"] . '">
                <p><img src="https://image.tmdb.org/t/p/w500/' . $value['poster_path'] . '"></p>
                </a>
                <h2>' . $value['title'] . '</h2>
                <p>Valoracion:' . $value['vote_average'] . '</p>
                </li>';
        }
        echo "</ul>";
        ?>
    </div>
</body>

</html>