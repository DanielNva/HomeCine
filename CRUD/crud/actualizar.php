<?php
include "../bd/conexion.php";
include "../models/response.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);

    // Agregar esta línea para ver los datos recibidos en los logs de errores de PHP
    error_log(print_r($data, true));

    if (!empty($data['id']) && !empty($data['title']) && !empty($data['poster_path']) && !empty($data['vote_average'])) {
        $id = $data['id'];
        $title = $data['title'];
        $poster_path = $data['poster_path'];
        $vote_average = $data['vote_average'];

        $database = new Database();
        $conn = $database->getConnection();

        $sql = "UPDATE peliculas SET title=?, poster_path=?, vote_average=? WHERE id=?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            echo json_encode(new Response("Error en la preparación de la consulta", 500, false));
            exit();
        }

        if ($stmt->execute([$title, $poster_path, $vote_average, $id])) {
            echo json_encode(new Response("Película actualizada exitosamente", 200, true));
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(new Response("Error al actualizar la película: " . $errorInfo[2], 500, false));
        }

        $stmt->closeCursor();
        $conn = null;
    } else {
        echo json_encode(new Response("Datos incompletos", 400, false));
    }
    exit();
}
?>
