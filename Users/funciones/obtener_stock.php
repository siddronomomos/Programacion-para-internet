<?php
include ('./conecta.php');

$conn = conecta();

if (isset($_POST['id'])) {
    $prodid = intval($_POST['id']);
    $prodsql = "SELECT stock FROM productos WHERE id = $prodid";
    $result = $conn->query($prodsql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo $product['stock'];
    } else {
        echo "Error: Producto no encontrado";
    }
} else {
    echo "Error: ID no proporcionado";
}
