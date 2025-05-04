<?php

Flight::route('GET /docs', function () {
    header('Content-Type: text/html');
    readfile(__DIR__ . '/../swagger/index.html');
});

Flight::route('GET /swagger.yaml', function () {
    header('Content-Type: application/yaml');
    readfile(__DIR__ . '/../swagger/swagger.yaml');
});
