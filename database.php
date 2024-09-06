<?php
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $db_name = "edificios";

    // Crear una nueva conexión a la base de datos usando la clase MySQLi
    $conn = new mysqli($servername, $username, $password, $db_name);

    // Verificar si la conexión fue exitosa
    if ($conn->connect_errno) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    //  echo "Conexión exitosa";
?>
