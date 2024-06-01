<?php

//Extraer los datos y guardarlos en la base de datos

// Consultar la API y almacenar los datos en la base de datos
if (isset($array['results']) && is_array($array['results'])) {
    foreach ($array['results'] as $value) {
        if (isset($value['id'], $value['poster_path'], $value['title'], $value['vote_average'])) {
            // Preparar la consulta SQL para insertar los datos en la base de datos
            $sql = "INSERT INTO peliculas (id, title, poster_path, vote_average) VALUES (?, ?, ?, ?)
                     ON DUPLICATE KEY UPDATE title=VALUES(title), poster_path=VALUES(poster_path), vote_average=VALUES(vote_average)";
            $stmt = $conn->prepare($sql);

            // Manejar posibles errores en la preparación de la consulta
            if (!$stmt) {
                die("Error en la preparación de la consulta: " . $conn->error);
            }

            $stmt->bind_param("isss", $value['id'], $value['title'], $value['poster_path'], $value['vote_average']);

            // Ejecutar la consulta y manejar posibles errores en la ejecución
            if ($stmt->execute()) {
                continue; // Continúa después de insertar la película
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}