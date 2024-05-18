<?php
include ('conecta.php');
if (isset($_GET['id'])) {

    $conn = conecta();

    if (!$conn) {
        exit("Error al conectar a la base de datos");
    }

    $sql = "UPDATE empleados SET activo = 0 WHERE id = $id_empleado";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../listado_empleados.php");
        exit();
    } else {
        echo "Error al eliminar empleado: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No se ha proporcionado el ID del empleado a eliminar.";
}
