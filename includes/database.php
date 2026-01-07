<?php

function conectarDB() : mysqli {
    // Local - config
    
    // $db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
    
    
    // if (!$db) {
    //     echo "Error: No se pudo conectar a MySQL.";
    //     echo "errno de depuración: " . mysqli_connect_errno();
    //     echo "error de depuración: " . mysqli_connect_error();
    //     exit;
    // }
    // return $db;

    // TiDB - config

    $db = mysqli_init();

    $db->ssl_set(NULL, NULL, NULL, NULL, NULL);

    $db->real_connect(
        $_ENV['DB_HOST'] ?? '',
        $_ENV['DB_USER'] ?? '', 
        $_ENV['DB_PASS'] ?? '', 
        $_ENV['DB_NAME'] ?? '',
        $_ENV['DB_PORT'] ?? 4000,
        NULL,
        MYSQLI_CLIENT_SSL
    );

    if ($db->connect_errno) {
        echo "Error: No se pudo conectar a MySQL (TiDB).<br>";
        echo "Errno: " . $db->connect_errno . "<br>";
        echo "Error: " . $db->connect_error;
        exit;
    }

    $db->set_charset("utf8mb4");

    return $db;
}

