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
    <title>Detalle de producto</title>
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

        .producto {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
        }

        .producto div {
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
        $producto_id = $_GET['id'];

        $sql = "SELECT nombre, codigo, descripcion, costo, stock, status, archivo_n as archivo FROM productos WHERE id = $producto_id";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h2>Detalle de producto</h2>";
            echo "<div class='producto'>";
            echo "<div>Nombre: " . $row["nombre"] . "</div>";
            echo "<div>Codigo: " . $row["codigo"] . "</div>";
            echo "<div>Descripción: " . $row["descripcion"] . "</div>";
            echo "<div>Costo: $" . $row["costo"] . "</div>";
            echo "<div>Stock: " . $row["stock"] . "</div>";
            echo "<div>Activo: " . ($row["status"] ? "Sí" : "No") . "</div>";
            echo "<img src='./images/" . $row["archivo"] . "' alt='Foto de producto' style='max-width:150px;width:100%'>";
            echo "</div>";
            echo "<p><a href='javascript:history.back()'>Regresar al listado</a></p>";
        } else {
            echo "<p>No se encontró el producto.</p>";
        }
    } else {
        echo "<p>No se proporcionó un ID de producto válido.</p>";
    }

    $conn->close();
    ?>
</body>

</html>