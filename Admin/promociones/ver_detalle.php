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
    <title>Detalle de promocion</title>
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

        .promocion {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
        }

        .promocion div {
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
        $promocion_id = $_GET['id'];

        $sql = "SELECT * FROM promociones WHERE id = $promocion_id";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h2>Detalle de promocion</h2>";
            echo "<div class='promocion'>";
            echo "<div>Nombre: " . $row["nombre"] . "</div>";
            echo "<div>Activo: " . ($row["status"] ? "Sí" : "No") . "</div>";
            echo "<img src='./images/" . $row["archivo"] . "' alt='Foto de promocion' style='max-width:150px;width:100%'>";
            echo "</div>";
            echo "<p><a href='javascript:history.back()'>Regresar al listado</a></p>";
        } else {
            echo "<p>No se encontró la promocion.</p>";
        }
    } else {
        echo "<p>No se proporcionó un ID de promocion válido.</p>";
    }

    $conn->close();
    ?>
</body>

</html>