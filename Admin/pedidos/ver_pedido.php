<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de empleado</title>
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

        p a {
            text-decoration: none;
            color: #007bff;
        }

        p a:hover {
            text-decoration: underline;
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
</head>

<body>
    <h2>Ver Detalle</h2>
    <div class="menu">
        <a href="../bienvenido.php">INICIO</a>
        <a href="../empleados/listado_empleados.php">EMPLEADOS</a>
        <a href="../productos/listado_productos.php">PRODUCTOS</a>
        <a href="../promociones/listado_promociones.php">PROMOCIONES</a>
        <a href="../pedidos/listado_pedidos.php">PEDIDOS</a>
        <a href="#">BIENVENIDO <?php echo $nombreUsuario; ?></a>
        <a href="./funciones/cerrar_sesion.php">CERRAR SESIÓN</a>
    </div>
    <?php
    include ('./funciones/conecta.php');
    $conn = conecta();

    if (!$conn) {
        exit("Error al conectar a la base de datos");
    }

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $pedido_id = $_GET['id'];
        $sql = "SELECT * FROM pedidos WHERE id = $pedido_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $pedido = $result->fetch_assoc();
            $productos = unserialize($pedido['productos']);
            $total = 0;
            $values = array_count_values($productos);
            $ids = array_keys($values);
            $in = implode(',', $ids);
            $useri = $pedido['userid'];
            $sql = "SELECT * FROM usuarios WHERE id = $useri";
            $res = $conn->query($sql);
            $user = $res->fetch_assoc();




            echo "<div class=\"empleado\">";
            echo "<div> ID: " . $pedido['id'] . "</div>";
            echo "<div> Usuario: " . $user['username'] . "</div>";
            echo "<div> Productos: </div>";

            $sql = "SELECT * FROM productos WHERE id IN ($in)";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $total += $row['costo'] * $values[$row['id']];
                    $subtotal = $row['costo'] * $values[$row['id']];
                    echo "<div> - " . $row['nombre'] . " - Cantidad: " . $values[$row['id']] . " - Precio: $" . $row['costo'] . " - Subtotal: $" . $subtotal . "</div>";
                    echo "<img src=\"../productos/images/" . $row['archivo_n'] . "\" width=\"100\" height=\"100\">";
                }

            }
            echo "<div> Total: $" . $total . "</div>";
        }
    }




    $conn->close();
    ?>

    <div class="acciones">
        <a href="./listado_pedidos.php">Volver</a>
    </div>

</body>

</html>