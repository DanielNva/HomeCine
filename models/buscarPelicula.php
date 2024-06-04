<?php
include_once "./bd/conexion.php";
include_once "./controllers/buscarPelicula.php";

$searchQuery = '';
if (isset($_GET['q'])) {
    $searchQuery = $_GET['q'];
}

// Buscar las películas en la base de datos según el término de búsqueda
$sql = "SELECT id, title, poster_path, vote_average FROM peliculas WHERE title LIKE ?";
$stmt = $conn->prepare($sql);

// Manejar posibles errores en la preparación de la consulta
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$searchTerm = '%' . $searchQuery . '%';
$stmt->bind_param("s", $searchTerm);

// Ejecutar la consulta y manejar posibles errores en la ejecución
if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<li>
                <a href="detalles.php?id=' . htmlspecialchars($row["id"]) . '">
                <p><img src="https://image.tmdb.org/t/p/w500/' . htmlspecialchars($row['poster_path']) . '" alt="' . htmlspecialchars($row['title']) . '"></p>
                </a>
                <h2>' . htmlspecialchars($row['title']) . '</h2>
                <p>Valoración: ' . htmlspecialchars($row['vote_average']) . '</p>
                </li>';
        }
    } else {
        echo '<p>No se encontraron resultados.</p>';
    }
} else {
    echo "Error al ejecutar la consulta: " . $stmt->error;
}

$stmt->close();
$conn->close();

