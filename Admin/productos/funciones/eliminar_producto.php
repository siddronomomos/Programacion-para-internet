<?php
include ('conecta.php');
if (isset($_GET['id'])) {

    $conn = conecta();

    if (!$conn) {
        exit("Error al conectar a la base de datos");
    }

    $id_producto = $_GET['id'];

    $sqlArchivo = "SELECT archivo_n FROM productos WHERE id = $id_producto";
    $result = $conn->query($sqlArchivo);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $archivo = $row['archivo_n'];
        if (file_exists("../images/$archivo")) {
            unlink("../images/$archivo");
        }
    }


    $sql = "UPDATE productos SET eliminado = 1 WHERE id = $id_producto";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../listado_productos.php");
        exit();
    } else {
        echo "Error al eliminar producto: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No se ha proporcionado el ID del producto a eliminar.";
}
