<?php
include "database.php";

// Predefinir valores para el menú desplegable de "Lugar"
$lugar_options = [
    'Sótano',
    'Primer Nivel',
    'Segundo Nivel',
    'Tercer Nivel',
    'Cuarto Nivel',
    'Quinto Nivel',
    'Sexto Nivel',
    'Séptimo Nivel',
    'Fuera del Edificio'
];

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if (!isset($_GET['id'])) {
        header("location:/index.php");
        exit;
    }
    $id = $_GET['id'];

    // Obtener datos del lugar
    $sql_lugar = "SELECT * FROM lugares WHERE id=$id";
    $result_lugar = $conn->query($sql_lugar);
    $lugar = $result_lugar->fetch_assoc();

    if (!$lugar) {
        header("location:/index.php");
        exit;
    }

    // Obtener datos del área
    $lugar_id = $lugar["id"];
    $sql_area = "SELECT * FROM areas WHERE lugar_id=$lugar_id";
    $result_area = $conn->query($sql_area);
    $area = $result_area->fetch_assoc();

    // Obtener datos de la subárea
    $area_id = $area["id"];
    $sql_subarea = "SELECT * FROM subareas WHERE area_id=$area_id";
    $result_subarea = $conn->query($sql_subarea);
    $subarea = $result_subarea->fetch_assoc();

    // Obtener datos del teléfono
    $subarea_id = $subarea["id"];
    $sql_telefono = "SELECT * FROM telefonos WHERE subarea_id=$subarea_id";
    $result_telefono = $conn->query($sql_telefono);
    $telefono = $result_telefono->fetch_assoc();

    // Asignar valores a las variables para el formulario
    $lugar_nombre = $lugar["nombre"];
    $direccion = $lugar["direccion"];
    $area_nombre = $area["nombre"];
    $subarea_nombre = $subarea["nombre"];
    $telefono_numero = $telefono["numero"];
} else {
    $id = $_POST["id"];
    $lugar = $_POST["lugar"];
    $direccion = $_POST["direccion"];
    $area = $_POST["area"];
    $subarea = $_POST["subarea"];
    $telefono = $_POST["telefono"];

    // Actualizar lugar
    $sql_lugar = "UPDATE lugares SET nombre='$lugar', direccion='$direccion' WHERE id='$id'";
    $conn->query($sql_lugar);

    // Obtener ID actualizado del lugar
    $lugar_id = $id;

    // Actualizar área
    $sql_area = "UPDATE areas SET nombre='$area' WHERE lugar_id='$lugar_id'";
    $conn->query($sql_area);

    // Obtener ID actualizado del área
    $area_id_query = "SELECT id FROM areas WHERE lugar_id='$lugar_id'";
    $result_area_id = $conn->query($area_id_query);
    $area_id = $result_area_id->fetch_assoc()["id"];

    // Actualizar subárea
    $sql_subarea = "UPDATE subareas SET nombre='$subarea' WHERE area_id='$area_id'";
    $conn->query($sql_subarea);

    // Obtener ID actualizado de la subárea
    $subarea_id_query = "SELECT id FROM subareas WHERE area_id='$area_id'";
    $result_subarea_id = $conn->query($subarea_id_query);
    $subarea_id = $result_subarea_id->fetch_assoc()["id"];

    // Actualizar teléfono
    $sql_telefono = "UPDATE telefonos SET numero='$telefono' WHERE subarea_id='$subarea_id'";
    $query = $conn->query($sql_telefono);

    if ($query) {
        header("Location: /index.php");
        exit;
    } else {
        $error = "Error al actualizar el registro.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>CRUD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="col-lg-6 m-auto">
        <form method="post">
            <br><br>
            <div class="card">
                <div class="card-header bg-secondary">
                    <h1 class="text-black text-center">Actualizar registro</h1>
                </div><br>

                <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control"> <br>

                <!-- Lugar -->
                <label for="lugar">Lugar:</label>
                <select name="lugar" class="form-control" required>
                    <?php foreach ($lugar_options as $lugar_option): ?>
                        <option value="<?php echo htmlspecialchars($lugar_option); ?>" <?php echo ($lugar_option === $lugar_nombre) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($lugar_option); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>

                <!-- Dirección del Lugar -->
                <label for="direccion">Dirección del Lugar:</label>
                <input type="text" name="direccion" class="form-control" value="<?php echo htmlspecialchars($direccion); ?>" required> <br>

                <!-- Área -->
                <label for="area">Área:</label>
                <input type="text" name="area" class="form-control" value="<?php echo htmlspecialchars($area_nombre); ?>" placeholder="Ej. Informática, Administración, etc." required> <br>

                <!-- Subárea -->
                <label for="subarea">Subárea:</label>
                <input type="text" name="subarea" class="form-control" value="<?php echo htmlspecialchars($subarea_nombre); ?>" placeholder="Ej. Recepción, Técnicos, etc." required> <br>

                <!-- Teléfono -->
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($telefono_numero); ?>" placeholder="Ej. 123-456-7890" required> <br>

                <!-- Botones de Envío y Cancelación -->
                <button class="btn btn-success" type="submit" name="submit">Submit</button><br>
                <a class="btn btn-info" href="index.php">Cancel</a><br>
            </div>
        </form>
    </div>
</body>

</html>
