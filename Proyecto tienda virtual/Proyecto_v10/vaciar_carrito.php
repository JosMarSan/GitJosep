<?php
// Conectarse a la base de datos (reemplaza con tus propias credenciales)
$servername = "localhost";
$username = "root";
$password = "";
$datbasename = "Info_C360";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $datbasename);

// Comprobar conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Eliminar todos los datos de la tabla carrito
$sql = "DELETE FROM carrito";

if (mysqli_query($conn, $sql)) {
    header("Location: carrito.php");
} else {
    echo "Error al vaciar el carrito: " . mysqli_error($conn);
}

// Cerrar conexión
mysqli_close($conn);
?>