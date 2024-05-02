<?php
if(isset($_GET['id'])) {
    $id_empleado = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "proyecto final";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "UPDATE db SET activo = 0 WHERE id = $id_empleado";

    if ($conn->query($sql) === TRUE) {
        header("Location: listado_empleados.php");
        exit();
    } else {
        echo "Error al eliminar empleado: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No se ha proporcionado el ID del empleado a eliminar.";
}
?>
