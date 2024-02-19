<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Info_C360";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$nombre = $_POST["nombre"] ?? "";
$apellido = $_POST["apellido"] ?? "";
$correo_electronico = $_POST["correo"] ?? "";
$contrasena = $_POST["contrasena"] ?? "";

$hash_contrasena = password_hash($contrasena, PASSWORD_BCRYPT);

if ($nombre && $apellido && $correo_electronico && $contrasena) {
    $result = mysqli_query($conn, "SELECT id_usuario FROM Usuarios WHERE correo = '$correo_electronico'");

    if (mysqli_num_rows($result) > 0) {
        header("Location: registrar2.html");
        exit;
    } else {
        mysqli_query($conn, "INSERT INTO usuarios (nombre, apellido, correo, contrasena) VALUES ('$nombre', '$apellido', '$correo_electronico', '$hash_contrasena')");
        header("Location: registrar3.html");
        exit;
    }
} else {
    echo "Todos los campos del formulario son obligatorios";
}

mysqli_close($conn);
?>