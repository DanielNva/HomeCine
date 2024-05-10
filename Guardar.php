<?php
session_start();
if (($_SESSION["n1"] + $_SESSION["n2"]) == $_POST['seguridad']) {
    $comentarios = [];
    $ruta = "./comentarios/{$_POST['id']}.txt";
    if (file_exists($ruta)) {
        $comentarios = unserialize(file_get_contents($ruta));
    }
    $comentarios[] = [strip_tags($_POST['comentario']), strip_tags($_POST['nombre']), strip_tags($_POST[('mail')]), date("d/m/y")];
    file_put_contents($ruta, serialize($comentarios));
} else {
    $_SESSION["n1"] = rand(1, 9);
    $_SESSION["n2"] = rand(1, 9);
    header("Location: detalles.php?id=" . $_POST["id"]);
    exit();
}
