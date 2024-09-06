<?php
include "database.php";

// Verifica si 'id' está presente en la solicitud GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Asegúrate de que 'id' sea numérico
    if (is_numeric($id)) {
        $id = $conn->real_escape_string($id);

        // Consulta SQL para actualizar el estado en la tabla 'lugares'
        $sql = "UPDATE lugares SET estado='inactivo' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid ID parameter.";
    }
} else {
    echo "No 'id' parameter provided.";
}

// Redirecciona a /index.php después de un breve retraso para ver el mensaje
sleep(2);
header('Location: /index.php');
exit;
?>
