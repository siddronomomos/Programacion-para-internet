<?php
include ('conecta.php');
if (isset($_GET['id'])) {

    $conn = conecta();

    if (!$conn) {
        exit("Error al conectar a la base de datos");
    }

    $id_empleado = $_GET['id'];

    $sqlArchivo = "SELECT foto_encrypt FROM empleados WHERE id = $id_empleado";
    $result = $conn->query($sqlArchivo);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $archivo = $row['foto_encrypt'];
        if (file_exists("../images/$archivo")) {
            unlink("../images/$archivo");

        }
    }

    $sql = "UPDATE empleados SET eliminado = 1 WHERE id = $id_empleado";

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
