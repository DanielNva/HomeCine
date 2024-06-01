<!-- actualizar_pelicula.php -->
<?php
include "../../bd/conexion.php"; // Incluir la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $poster_path = $_POST['poster_path'];
    $vote_average = $_POST['vote_average'];

    $sql = "UPDATE peliculas SET title=?, poster_path=?, vote_average=? WHERE id=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("sssi", $title, $poster_path, $vote_average, $id);

    if ($stmt->execute()) {
        echo "Película actualizada correctamente.";
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../index.php");
    exit();
}
?>
