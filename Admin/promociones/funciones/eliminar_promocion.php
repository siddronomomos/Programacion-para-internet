<?php
include ('conecta.php');
if (isset($_GET['id'])) {

    $conn = conecta();

    if (!$conn) {
        exit("Error al conectar a la base de datos");
    }

    $id_promocion = $_GET['id'];

    $sqlArchivo = "SELECT archivo FROM promociones WHERE id = $id_promocion";
    $result = $conn->query($sqlArchivo);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $archivo = $row['archivo'];
        if (file_exists("../images/$archivo")) {
            unlink("../images/$archivo");
        }
    }

    $sql = "UPDATE promociones SET eliminado = 1 WHERE id = $id_promocion";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../listado_promociones.php");
        exit();
    } else {
        echo "Error al eliminar promocion: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No se ha proporcionado el ID de la promocion a eliminar.";
}
