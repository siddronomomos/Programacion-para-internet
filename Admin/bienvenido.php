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
    <title>Bienvenido al sistema</title>
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
        }

        .welcome {
            text-align: center;
            margin-bottom: 20px;
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
    </style>
</head>

<body>
    <div class="container">
        <h2 class="title">Bienvenido al sistema</h2>
        <div class="welcome">
            <p>Hola, <?php echo $nombreUsuario; ?>. ¡Bienvenido al sistema!</p>
        </div>
        <div class="menu">
            <a href="bienvenido.php">INICIO</a>
            <a href="./empleados/listado_empleados.php">EMPLEADOS</a>
            <a href="./productos/listado_productos.php">PRODUCTOS</a>
            <a href="./promociones/listado_promociones.php">PROMOCIONES</a>
            <a href="./pedidos/listado_pedidos.php">PEDIDOS</a>
            <a href="#">BIENVENIDO <?php echo $nombreUsuario; ?></a>
            <a href="./empleados/funciones/cerrar_sesion.php">CERRAR SESIÓN</a>
        </div>
    </div>
</body>

</html>