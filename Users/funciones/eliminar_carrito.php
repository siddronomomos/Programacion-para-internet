<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
    exit();
}

include ('./conecta.php');

$conn = conecta();

$nombreUsuario = $_SESSION['username'];
$productId = intval($_GET['id']);

$usersql = "SELECT * FROM usuarios WHERE username = '$nombreUsuario'";
$userresult = $conn->query($usersql);
$user = $userresult->fetch_assoc();
$cart = unserialize($user['cart']);

if (($key = array_search($productId, $cart)) !== false) {
    unset($cart[$key]);
    $updatedCart = serialize(array_values($cart));

    $updateCartSql = "UPDATE usuarios SET cart = '$updatedCart' WHERE username = '$nombreUsuario'";
    if ($conn->query($updateCartSql) === TRUE) {
        echo "Producto eliminado del carrito.";
    } else {
        echo "Error al eliminar el producto del carrito.";
    }
} else {
    echo "Error: Producto no encontrado en el carrito.";
}

header("Location: ../carrito.php");
exit();

?>