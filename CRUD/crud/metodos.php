<?php
include "../../bd/conexion.php";
include "../../models/response.php";

header('Content-Type: application/json');
$request_method = $_SERVER["REQUEST_METHOD"];

$database = new Database();
$db = $database->getConnection();

switch($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            get_peliculas($id);
        } else {
            get_peliculas();
        }
        break;
    case 'POST':
        create_pelicula();
        break;
    case 'PUT':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            update_pelicula($id);
        } else {
            echo json_encode(new Response("ID no proporcionado", 400, false));
        }
        break;
    case 'DELETE':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            delete_pelicula($id);
        } else {
            echo json_encode(new Response("ID no proporcionado", 400, false));
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_peliculas($id = 0) {
    global $db;
    $query = "SELECT * FROM peliculas";
    if($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $stmt = $db->prepare($query);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($response);
}

function create_pelicula() {
    global $db;
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->title) && isset($data->poster_path) && isset($data->vote_average)) {
        $sql = "INSERT INTO peliculas (title, poster_path, vote_average) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        if($stmt->execute([$data->title, $data->poster_path, $data->vote_average])) {
            $response = new Response("Película agregada exitosamente", 200, true);
        } else {
            $response = new Response("Error al agregar la película", 500, false);
        }
    } else {
        $response = new Response("Datos incompletos", 400, false);
    }
    echo json_encode($response);
}

function update_pelicula($id) {
    global $db;
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->title) && isset($data->poster_path) && isset($data->vote_average)) {
        $sql = "UPDATE peliculas SET title = ?, poster_path = ?, vote_average = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        if($stmt->execute([$data->title, $data->poster_path, $data->vote_average, $id])) {
            $response = new Response("Película actualizada exitosamente", 200, true);
        } else {
            $response = new Response("Error al actualizar la película", 500, false);
        }
    } else {
        $response = new Response("Datos incompletos", 400, false);
    }
    echo json_encode($response);
}

function delete_pelicula($id) {
    global $db;
    $sql = "DELETE FROM peliculas WHERE id = ?";
    $stmt = $db->prepare($sql);
    if($stmt->execute([$id])) {
        $response = new Response("Película eliminada exitosamente", 200, true);
    } else {
        $response = new Response("Error al eliminar la película", 500, false);
    }
    echo json_encode($response);
}
?>
