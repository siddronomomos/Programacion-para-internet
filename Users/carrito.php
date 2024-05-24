<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
    exit();
}

include ('./funciones/conecta.php');

$conn = conecta();


$nombreUsuario = $_SESSION['username'];

$productossql = "SELECT * FROM productos WHERE status = 1 AND eliminado = 0";

$productresult = $conn->query($productossql);

$usersql = "SELECT * FROM usuarios WHERE username = '$nombreUsuario'";

$userresult = $conn->query($usersql);

$user = $userresult->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }

    .title {
        margin-bottom: 20px;
        text-align: center;
        font-size: 24px;
    }

    .welcome {
        margin-bottom: 20px;
        text-align: center;
    }

    .menu {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .menu a {
        padding: 10px;
        margin: 0 10px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .menu a:hover {
        background-color: #0056b3;
    }



    .product-list-title {
        text-align: center;
        margin-bottom: 20px;
        color: #007bff;
    }

    .products-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .product {
        text-align: center;
        border: 1px solid #ccc;
        padding: 10px;
        max-width: 300px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        min-height: 550px;
    }

    .product-img {
        width: 300px;
        height: 300px;
        object-fit: cover;
    }

    .product-info {
        margin-top: 20px;
    }

    .total {
        text-align: center;
        font-size: 24px;
        margin-top: 20px;
    }

    .cart-title {
        text-align: center;
        margin-bottom: 20px;
        color: #007bff;
    }

    .btn {
        padding: 10px;
        margin-top: 10px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .buy {
        display: block;
        margin: 0 auto;
        width: 200px;
        text-align: center;
    }
</style>

<body>
    <div class="container">
        <div class="title"> Bienvenido <?php echo $nombreUsuario; ?></div>
        <div class="welcome"></div>
        <div class="menu">
            <a href="./index.php">Home</a>
            <a href="./productos.php">Productos</a>
            <a href="./contacto.php">Contacto</a>
            <a href="./carrito.php">Carrito</a>
            <a href="./funciones/cerrar_sesion.php">Cerrar sesión</a>
        </div>
    </div>

    <h2 class="cart-title">Tus articulos en el carrito</h2>

    <?php

    if (!empty($user['cart'])) {
        $total = 0;
        $cart = unserialize($user['cart']);
        $values = array_count_values($cart);
        $ids = array_keys($values);
        $in = implode(',', $ids);
        $cartsql = "SELECT * FROM productos WHERE id IN ($in)";
        $cartresult = $conn->query($cartsql);
        echo "<div class=\"products-container\">";
        while ($cartrow = $cartresult->fetch_assoc()) {
            $quantity = $values[$cartrow['id']];
            $total += $cartrow['costo'] * $quantity;
            $subtotal = $cartrow['costo'] * $quantity;
            echo "<div class=\"product\">";
            echo "<img src=../Admin/productos/images/{$cartrow['archivo_n']} alt={$cartrow['nombre']} class=\"product-img\">";
            echo "<div class=\"product-info\">";
            echo "<h3>{$cartrow['nombre']}</h3>";
            echo "<p>Precio: {$cartrow['costo']}$</p>";
            echo "<p>Cantidad: $quantity</p>";
            echo "<p>Subtotal: $subtotal$</p>";
            echo "<a class=\"btn btn-danger\" href=\"./funciones/eliminar_carrito.php?id={$cartrow['id']}\">Eliminar</a>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "<p class=\"total\">Total: $total$</p>";
        echo "<a class=\"btn buy\" href=\"./funciones/comprar.php\">Cerrar Pedido</a>";
        echo "</div>";
    } else {
        echo "<p>No hay productos en el carrito</p>";
    }

    ?>
</body>

</html>