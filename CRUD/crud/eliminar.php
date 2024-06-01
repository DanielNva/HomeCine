
<?php
include "../../bd/conexion.php"; // Incluir la conexión a la base de datos
include "../../models/response.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    header('Content-Type: application/json');

    $sql = "DELETE FROM peliculas WHERE id=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $miObjeto = new Response("se elimino la pelicula", 200, true);
        echo json_encode($miObjeto);
    } else {
        $miObjeto = new Response("error al eliminar la pelicula", 404, false);
        echo json_encode($miObjeto);
    }

    $stmt->close();
    $conn->close();
    header("Location: ../crud.php"); // Redirect to crud.php
    exit();
}
?>
