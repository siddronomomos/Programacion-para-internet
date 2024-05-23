<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
    exit();
}

$nombreUsuario = $_SESSION['username'];

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
        <div class="title"> Bienvenido <?php echo $nombreUsuario; ?></div>
        <div class="welcome">
        </div>
        <div class="menu">
            <a href="bienvenido.php">Home</a>
            <a href="./empleados/listado_empleados.php">Productos</a>
            <a href="./productos/listado_productos.php">Contacto</a>
            <a href="./promociones/listado_promociones.php">Carrito</a>
            <a href="./funciones/cerrar_sesion.php">Cerrar sesion</a>
        </div>
    </div>
</body>

</html>