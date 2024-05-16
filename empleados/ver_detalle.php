<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
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
            <a href="bienvenido.php">INICIO</a>
            <a href="listado_empleados.php">EMPLEADOS</a>
            <a href="#">PRODUCTOS</a>
            <a href="#">PROMOCIONES</a>
            <a href="#">PEDIDOS</a>
            <a href="#">BIENVENIDO <?php echo $nombreUsuario; ?></a>
            <a href="cerrar_sesion.php">CERRAR SESIÓN</a>
        </div>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "proyecto final";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $empleado_id = $_GET['id'];

    $sql = "SELECT nombre, apellidos, correo, rol, activo, foto_encrypt as foto_real FROM db WHERE id=$empleado_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h2>Detalle de empleado</h2>";
        echo "<div class='empleado'>";
        echo "<div>Nombre: ".$row["nombre"]." ".$row["apellidos"]."</div>";
        echo "<div>Correo: ".$row["correo"]."</div>";
        echo "<div>Rol: ".$row["rol"]."</div>";
        echo "<div>Activo: ".($row["activo"] ? "Sí" : "No")."</div>";
        echo "<img src='uploads/".$row["foto_real"]."' alt='Foto de empleado' style='max-width:150px;width:100%'>";
        echo "</div>";
        echo "<p><a href='javascript:history.back()'>Regresar al listado</a></p>";
    } else {
        echo "<p>No se encontró el empleado.</p>";
    }
} else {
    echo "<p>No se proporcionó un ID de empleado válido.</p>";
}

$conn->close();
?>
</body>
</html>
