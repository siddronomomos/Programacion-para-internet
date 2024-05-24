<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$nombreUsuario = $_SESSION['usuario'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    h2 {
        margin-bottom: 20px;
    }

    .empleado {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #fff;
    }

    .empleado div {
        margin-bottom: 5px;
    }

    .acciones a {
        text-decoration: none;
        color: #007bff;
        margin-right: 10px;
    }

    .acciones a:hover {
        text-decoration: underline;
    }

    .acciones a.eliminar {
        color: #dc3545;
    }

    .acciones a.eliminar:hover {
        color: #c82333;
    }

    .acciones a.detalle {
        color: #28a745;
    }

    .acciones a.detalle:hover {
        color: #218838;
    }

    p a {
        text-decoration: none;
        color: #007bff;
    }

    p a:hover {
        text-decoration: underline;
    }

    .foto-empleado {
        text-align: center;
        max-width: 200px;
        max-height: 200px;
        overflow: auto;
    }

    .menu {
        text-align: center;
        margin-bottom: 20px;
    }

    .menu a {
        margin-right: 10px;
        text-decoration: none;
        color: #007bff;
    }

    .menu a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <h2>Pedidos Cerrados</h2>
    <div class="menu">
        <a href="../bienvenido.php">INICIO</a>
        <a href="../empleados/listado_empleados.php">EMPLEADOS</a>
        <a href="../productos/listado_productos.php">PRODUCTOS</a>
        <a href="../promociones/listado_promociones.php">PROMOCIONES</a>
        <a href="../pedidos/listado_pedidos.php">PEDIDOS</a>
        <a href="#">BIENVENIDO <?php echo $nombreUsuario; ?></a>
        <a href="./funciones/cerrar_sesion.php">CERRAR SESIÓN</a>
    </div>
    <div id="listadoEmpleados">
        <?php
        include ('./funciones/conecta.php');
        $conn = conecta();
        if (!$conn) {
            exit("Error al conectar a la base de datos");
        }

        $sql = "SELECT * FROM pedidos";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $total = 0;

                while ($row = $result->fetch_assoc()) {
                    $order = unserialize($row['productos']);
                    $values = array_count_values($order);
                    $ids = array_keys($values);
                    $in = implode(',', $ids);
                    $ordersql = "SELECT * FROM productos WHERE id IN ($in)";
                    $orderresult = $conn->query($ordersql);
                    $usersql = "SELECT * FROM usuarios WHERE id = {$row['userid']}";
                    $userresult = $conn->query($usersql);
                    $userrow = $userresult->fetch_assoc();
                    echo "<div class=\"empleado\">";
                    echo "<div> ID: " . $row["id"] . "</div>";
                    echo "<div> Productos: </div>";
                    echo "<div> Usuario: " . $userrow['username'] . "</div>";
                    while ($orderrow = $orderresult->fetch_assoc()) {
                        $total += $orderrow['costo'] * $values[$orderrow['id']];
                        $quantity = $values[$orderrow['id']];
                        $subtotal = $orderrow['costo'] * $quantity;
                        $sqlprod = "SELECT * FROM productos WHERE id = {$orderrow['id']}";
                        $resultprod = $conn->query($sqlprod);
                        $rowprod = $resultprod->fetch_assoc();
                        echo "<div> - " . $rowprod['nombre'] . " x " . $quantity . " = $" . $subtotal . "</div>";


                    }
                    echo "<div> Total: $" . $total . "</div>";
                    echo "<div class=\"acciones\"> <a href=\"./ver_pedido.php?id={$row['id']}\" class=\"detalle\">Ver Detalle</a></div>";
                    echo "</div>";

                }



            } else {
                echo "<p>No hay empleados registrados.</p>";
            }
        } else {
            echo "<p>Error al recuperar datos: " . $conn->error . "</p>";
        }

        $conn->close();
        ?>
    </div>



</body>

</html>