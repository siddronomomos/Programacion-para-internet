<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio de sesión</title>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 400px;
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

.form {
    display: flex;
    flex-direction: column;
}

.label {
    margin-bottom: 10px;
}

.input {
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.button {
    padding: 10px;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button:hover {
    background-color: #0056b3;
}

.error {
    color: red;
    margin-top: 10px;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#loginForm").submit(function(event) {
        event.preventDefault();
        var correo = $("#correo").val();
        var password = $("#password").val();

        if (correo === "" || password === "") {
            $("#mensaje").text("Faltan campos por llenar.");
        } else {
            $.ajax({
                type: "POST",
                url: "validar_usuario.php",
                data: {
                    correo: correo,
                    password: password
                },
                success: function(response) {
                    if (response === "existe") {
                        window.location.href = "bienvenido.php";
                    } else {
                        $("#mensaje").text("El usuario no existe o no está activo.");
                    }
                }
            });
        }
    });
});
</script>
</head>
<body>
<div class="container">
    <h2 class="title">Iniciar sesión</h2>
    <form id="loginForm" class="form">
        <label for="correo" class="label">Correo electrónico:</label>
        <input type="text" id="correo" name="correo" class="input" />

        <label for="password" class="label">Contraseña:</label>
        <input type="password" id="password" name="password" class="input" />

        <input type="submit" value="Iniciar sesión" class="button" />
    </form>
    <div id="mensaje" class="error"></div>
</div>
</body>
</html>