<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
    exit();
}

$nombreUsuario = $_SESSION['username'];

$productossql = "SELECT * FROM productos WHERE status = 1 AND eliminado = 0";

include ('./funciones/conecta.php');

$conn = conecta();

$productresult = $conn->query($productossql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".btn-cart").click(function (event) {
                event.preventDefault();
                var productContainer = $(this).closest('.product');
                $(this).hide();
                productContainer.find('.add-to-cart-form').show();
                productContainer.find('.cancel-cart').show();
            });

            $(".cancel-cart").click(function (event) {
                event.preventDefault();
                var productContainer = $(this).closest('.product');
                productContainer.find('.add-to-cart-form').hide();
                productContainer.find('.btn-cart').show();
                $(this).hide();
            });

            $(".add-to-cart-form").submit(function (event) {
                event.preventDefault();
                var productContainer = $(this).closest('.product');
                var productid = $(this).find("input[name='id']").val();
                var quantity = $(this).find("input[name='quantity']").val();

                $.ajax({
                    type: "POST",
                    url: "./funciones/agregar_carrito.php",
                    data: { id: productid, quantity: quantity },
                    success: function (response) {
                        productContainer.find(".cart-msg").text(response).show();
                        setTimeout(function () {
                            productContainer.find(".cart-msg").text("").hide();
                        }, 5000);

                        $.ajax({
                            type: "POST",
                            url: "./funciones/obtener_stock.php",
                            data: { id: productid },
                            success: function (newStock) {
                                if (!isNaN(newStock)) {
                                    productContainer.find(".stock").text("Stock: " + newStock);
                                    productContainer.find("input[name='quantity']").attr("max", newStock);
                                }
                            }
                        });
                    },
                });
            });
        });
    </script>
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

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-details {
            background-color: #007BFF;
            color: white;
        }

        .btn-details:hover {
            background-color: #0056b3;
        }

        .btn-cart {
            background-color: #28A745;
            color: white;
            border: none;
        }

        .btn-carty {
            background-color: #28A745;
            color: white;
            border: none;
        }

        .btn-cart:hover {
            background-color: #1e7e34;
        }

        .cart-msg {
            display: none;
            margin-top: 10px;
        }

        .add-to-cart-form {
            display: none;
            flex-direction: column;
            align-items: center;
            margin-top: 10px;
        }

        .cancel-cart {
            border: none;
            display: none;
            background-color: #dc3545;
            color: white;
            margin-top: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

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
    <h2 class="product-list-title">Productos</h2>
    <?php if ($productresult->num_rows > 0) {
        echo "<div class=\"products-container\">";
        while ($productrow = $productresult->fetch_assoc()) {
            $productname = $productrow['nombre'];
            $productprice = $productrow['costo'];
            $productimage = $productrow['archivo_n'];
            $productid = $productrow['id'];
            $productstock = $productrow['stock'];
            echo "<div class=\"product\">";
            echo "<h3 class=\"product-title\">$productname</h3>";
            echo "<img src=\"../Admin/productos/images/$productimage\" alt=\"$productname\" class=\"product-img\">";
            echo "<p>Precio: $productprice$</p>";
            echo "<p class=\"stock\">Stock: $productstock</p>";
            echo "<br>";
            echo "<a href=\"#\" class=\"btn btn-cart\" data-id=\"$productid\">Agregar al carrito</a>";
            echo "<form class=\"add-to-cart-form\">";
            echo "<input type=\"hidden\" name=\"id\" value=\"$productid\">";
            echo "<label for=\"quantity\">Cantidad:</label>";
            echo "<input type=\"number\" name=\"quantity\" id=\"quantity\" value=\"1\" min=\"1\" max=\"$productstock\">";
            echo "<br>";
            echo "<button type=\"submit\" class=\"btn btn-carty\">Agregar al carrito</button>";
            echo "</form>";
            echo "<button class=\"cancel-cart btn\">Cancelar</button>";
            echo "<p class=cart-msg></p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p class=\"no-products\">No hay productos disponibles</p>";
    } ?>
</body>

</html>