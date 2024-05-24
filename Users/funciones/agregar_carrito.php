<?php
session_start();
include ('./conecta.php');

$conn = conecta();

if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
    exit();
}

$nombreUsuario = $_SESSION['username'];
$prodid = intval($_POST['id']);
$productquantity = intval($_POST['quantity']);

$prodsql = "SELECT * FROM productos WHERE id = $prodid";
$productresult = $conn->query($prodsql);

$usersql = "SELECT * FROM usuarios WHERE username = '$nombreUsuario'";
$userresult = $conn->query($usersql);

if ($productresult->num_rows > 0 && $userresult->num_rows > 0) {
    $product = $productresult->fetch_assoc();
    $user = $userresult->fetch_assoc();
    $userid = $user['id'];
    $productid = $product['id'];

    if ($productquantity > 0 && $productquantity <= $product['stock']) {
        if (empty($user['cart'])) {
            $cart = array();
        } else {
            $cart = unserialize($user['cart']);
        }

        $current_count = array_count_values($cart);

        if (isset($current_count[$productid])) {
            $current_count[$productid] += $productquantity;
        } else {
            $current_count[$productid] = $productquantity;
        }

        $new_cart = array();
        foreach ($current_count as $id => $count) {
            for ($i = 0; $i < $count; $i++) {
                $new_cart[] = $id;
            }
        }

        $serializedCart = serialize($new_cart);

        $updateCartSql = "UPDATE usuarios SET cart = '$serializedCart' WHERE id = $userid";

        $newstock = $product['stock'] - $productquantity;

        $updateprodstocksql = "UPDATE productos SET stock = $newstock WHERE id = $productid";

        if ($conn->query($updateprodstocksql) !== TRUE) {
            die("Error al actualizar el stock del producto: " . $conn->error);
        }

        if ($conn->query($updateCartSql) === TRUE) {
            echo "Producto(s) agregado(s) al carrito correctamente.";
        } else {
            echo "Error al actualizar el carrito: " . $conn->error;
        }
    } else {
        echo "Error: Cantidad no válida";
    }
} else {
    echo "Error: Producto no encontrado";
}
