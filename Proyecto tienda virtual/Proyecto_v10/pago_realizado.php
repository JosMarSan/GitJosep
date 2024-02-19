<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar pago</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <a href="#" class="logo">C360</a>
        <nav class="nav">
            <ul class="menu">
                <li><a href="bienvenida.php">Inicio</a></li>
                <li><a href="productos.php">Cátalogo de productos</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <li><a href="cerrar_sesion.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>
    <div class="mensaje-pago" style="text-align: center;">
    <p>Pago realizado correctamente</p>
    </div>
</body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$datbasename = "Info_C360";

$conn = mysqli_connect($servername, $username, $password, $datbasename);

// Comprobar conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Eliminar todos los datos de la tabla carrito
$sql = "DELETE FROM carrito";

// Ejecutar la consulta SQL
if (mysqli_query($conn, $sql)) {
    // Consulta exitosa
} else {
    echo "Error al vaciar el carrito: " . mysqli_error($conn) . "<br>";
}

// Cerrar conexión
mysqli_close($conn);
?>
