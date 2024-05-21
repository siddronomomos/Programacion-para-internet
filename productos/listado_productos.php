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
    <title>Listado de productos</title>
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

        .foto-producto {
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
</head>

<body>
    <h2>Listado de productos</h2>
    <div class="menu">
        <a href="../bienvenido.php">INICIO</a>
        <a href="../empleados/listado_empleados.php">EMPLEADOS</a>
        <a href="../productos/listado_productos.php">PRODUCTOS</a>
        <a href="#">PROMOCIONES</a>
        <a href="#">PEDIDOS</a>
        <a href="#">BIENVENIDO <?php echo $nombreUsuario; ?></a>
        <a href="./funciones/cerrar_sesion.php">CERRAR SESIÓN</a>
    </div>
    <div id="listadoProductos">
        <?php
        include ('./funciones/conecta.php');
        $conn = conecta();
        if (!$conn) {
            exit("Error al conectar a la base de datos");
        }

        $sql = "SELECT id, nombre, codigo, descripcion, costo, stock, status, eliminado, archivo_n as archivo FROM productos";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row["eliminado"] == 1)
                        continue;
                    echo "<div class='producto'>";
                    echo "<div>ID: " . $row["id"] . "</div>";
                    echo "<div>Nombre: " . $row["nombre"] . "</div>";
                    echo "<div>Código: " . $row["codigo"] . "</div>";
                    echo "<div>Descripción: " . $row["descripcion"] . "</div>";
                    echo "<div>Costo: $" . $row["costo"] . "</div>";
                    echo "<div>Stock: " . $row["stock"] . "</div>";
                    echo "<div>Activo: " . ($row["status"] == 1 ? 'Sí' : 'No') . "</div>";
                    echo "<div class='foto-producto'><img src='./images/" . $row["archivo"] . "' alt='Foto de " . $row["nombre"] . "' style='max-width:150px;width:100%'></div>";
                    echo "<div class='acciones'><a href='editar_producto.php?id=" . $row["id"] . "'>Editar</a> | <a href='./funciones/eliminar_producto.php?id=" . $row["id"] . "' class='eliminar'>Eliminar</a> | <a href='ver_detalle.php?id=" . $row["id"] . "' class='detalle'>Ver detalle</a></div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay productos registrados.</p>";
            }
        } else {
            echo "<p>Error al recuperar datos: " . $conn->error . "</p>";
        }

        $conn->close();
        ?>
    </div>
    <p><a href="formulario_productos.php">Agregar nuevo producto</a></p>
</body>

</html>