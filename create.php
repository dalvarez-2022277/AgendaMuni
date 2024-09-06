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

if (isset($_POST['submit'])) {
    $lugar = $_POST['lugar'];
    $direccion = $_POST['direccion'];
    $area = $_POST['area'];
    $subarea = $_POST['subarea'];
    $telefono = $_POST['telefono'];
    $q_lugar = "INSERT INTO `lugares`(`nombre`, `estado`, `direccion`) VALUES ('$lugar', 'activo', '$direccion')";
    mysqli_query($conn, $q_lugar);
    $lugar_id = mysqli_insert_id($conn);
    $q_area = "INSERT INTO `areas`(`lugar_id`, `nombre`) VALUES ('$lugar_id', '$area')";
    mysqli_query($conn, $q_area);
    $area_id = mysqli_insert_id($conn);
    $q_subarea = "INSERT INTO `subareas`(`area_id`, `nombre`) VALUES ('$area_id', '$subarea')";
    mysqli_query($conn, $q_subarea);
    $subarea_id = mysqli_insert_id($conn);
    $q_telefono = "INSERT INTO `telefonos`(`subarea_id`, `numero`) VALUES ('$subarea_id', '$telefono')";
    $query = mysqli_query($conn, $q_telefono);

    if ($query) {
        header("Location: /index.php");
        exit;
    } else {
        echo "Error al insertar el registro.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Municipalidad de Guatemala</title>
    <link rel="icon" type="image/png" href="img/icono12.png" width="50px">
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
                <div class="card-header bg-primary">
                    <h1 class="text-white text-center">Crear nuevo Registro</h1>
                </div><br>

                <!-- Lugar -->
                <label for="lugar">Lugar:</label>
                <select name="lugar" class="form-control" required>
                    <?php foreach ($lugar_options as $lugar_option): ?>
                        <option value="<?php echo htmlspecialchars($lugar_option); ?>"><?php echo htmlspecialchars($lugar_option); ?></option>
                    <?php endforeach; ?>
                </select>
                <br>

                <!-- Dirección del Lugar -->
                <label for="direccion">Dirección del Lugar:</label>
                <input type="text" name="direccion" class="form-control" value="Central" required> <br>

                <!-- Área -->
                <label for="area">Área:</label>
                <input type="text" name="area" class="form-control" placeholder="Ej. Informática, Administración, etc." required> <br>

                <!-- Subárea -->
                <label for="subarea">Subárea:</label>
                <input type="text" name="subarea" class="form-control" placeholder="Ej. Recepción, Técnicos, etc." required> <br>

                <!-- Teléfono -->
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" class="form-control" placeholder="Ej. 123-456-7890" required> <br>

                <!-- Botones de Envío y Cancelación -->
                <button class="btn btn-success" type="submit" name="submit">Submit</button><br>
                <a class="btn btn-info" href="index.php">Cancel</a><br>
            </div>
        </form>
    </div>
</body>

</html>
