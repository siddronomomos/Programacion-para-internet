<?php
include ('./conecta.php');
session_start();

$conn = conecta();

$nombreUsuario = $_SESSION['username'];

if (isset($_POST['id'])) {
    $prodid = intval($_POST['id']);
    $usersql = "SELECT * FROM usuarios WHERE username = '$nombreUsuario'";
    $userresult = $conn->query($usersql);

    if ($userresult->num_rows > 0) {
        $user = $userresult->fetch_assoc();
        $cart = unserialize($user['cart']);
        $count = array_count_values($cart);
        echo $count[$prodid];
    } else {
        echo "Error: Usuario no encontrado";
    }
} else {
    echo "Error: ID no proporcionado";
}
