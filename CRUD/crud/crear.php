<?php
include "../../bd/conexion.php"; // Incluir la conexión a la base de datos
include "../../models/response.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $poster_path = $_POST['poster_path'];
    $vote_average = $_POST['vote_average'];

    header('Content-Type: application/json');

    $sql = "INSERT INTO peliculas (title, poster_path, vote_average) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("sss", $title, $poster_path, $vote_average);

    if ($stmt->execute()) {
        $miObjeto = new Response("se agrego la pelicula", 200, true);
        echo json_encode($miObjeto);
    } else {
        $miObjeto = new Response("error al agregar la pelicula", 404, false);
        echo json_encode($miObjeto);
    }

    $stmt->close();
    $conn->close();
    header("Location: ../crud.php"); // Redirect to crud.php
    exit(); 
}
?>