<?php
include ('conecta.php');
if (isset($_GET['id'])) {

    $conn = conecta();

    if (!$conn) {
        exit("Error al conectar a la base de datos");
    }

    $id_producto = $_GET['id'];

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
