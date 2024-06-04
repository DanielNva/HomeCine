<?php
include "../../bd/conexion.php"; // Incluir la conexión a la base de datos
include "../../models/response.php";

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $id = $_POST['id'];

    header('Content-Type: application/json');

    $sql = "DELETE FROM peliculas WHERE id=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $miObjeto = new Response("Error en la preparación de la consulta: " . $conn->error, 500, false);
        echo json_encode($miObjeto);
        exit();
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $miObjeto = new Response("Se eliminó la película", 200, true);
        echo json_encode($miObjeto);
    } else {
        $miObjeto = new Response("Error al eliminar la película", 404, false);
        echo json_encode($miObjeto);
    }

    $stmt->close();
    $conn->close();
    
    // Redirigir después de todas las operaciones
    header("Location: ../crud.php"); // Redirect to crud.php
    exit();
}

