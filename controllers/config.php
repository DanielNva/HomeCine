<?php

require_once '../dependencias.php';

$container = new Container();

$container->set('db', function($c) {
    return new Database('localhost', 'root', '', 'homecine');
});

?>
