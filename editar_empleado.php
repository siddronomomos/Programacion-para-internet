
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "proyecto final";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "SELECT * FROM db WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $apellidos = $row['apellidos'];
    $correo = $row['correo'];
    $rol = $row['rol'];
} else {
    echo "No se encontró el empleado.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edición de empleados</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    function validarCampos() {
        var nombre = $("#nombre").val();
        var apellidos = $("#apellidos").val();
        var correo = $("#correo").val();
        
        if (nombre === "" || apellidos === "" || correo === "") {
            $("#mensaje").text("Faltan campos por llenar.");
            return false;
        }
        return true;
    }

    $("#editarEmpleadoForm").submit(function(event) {
        event.preventDefault();
        if (!validarCampos()) {
            setTimeout(function () {
                $("#mensaje").text("");
            }, 5000);
            return;
        }

        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "actualizar_empleado.php",
            data: formData,
            success: function(response) {
                window.location.href = "listado_empleados.php";
            }
        });
    });

    $("#correo").blur(function () {
        var correo = $(this).val();
        $.ajax({
            type: "POST",
            url: "validar_correo.php",
            data: { correo: correo },
            success: function (response) {
                $("#errorContainer").text(response);
                setTimeout(function () {
                    $("#errorContainer").text("");
                }, 5000);
            }
        });
    });
});
</script>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
}

h2 {
    margin-bottom: 20px;
}

form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
}

label {
    display: block;
    margin-bottom: 10px;
}

input[type="text"],
input[type="email"],
select {
    width: calc(100% - 22px);
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

#errorContainer {
    color: red;
    margin-top: 10px;
}

p {
    text-align: center;
}

a {
    text-decoration: none;
    color: #007bff;
}

a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
<h2>Edición de empleados</h2>
<form id="editarEmpleadoForm">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" />

    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" />

    <label for="correo">Correo:</label>
    <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>" disabled />

    <label for="rol">Rol:</label>
    <select id="rol" name="rol">
        <option value="Gerente" <?php if ($rol === "Gerente") echo "selected"; ?>>Gerente</option>
        <option value="Ejecutivo" <?php if ($rol === "Ejecutivo") echo "selected"; ?>>Ejecutivo</option>
    </select>

    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="submit" value="Guardar" />
</form>
<div id="mensaje"></div>
<div id="errorContainer"></div>
<p><a href="listado_empleados.php">Regresar</a></p>
</body>
</html>
