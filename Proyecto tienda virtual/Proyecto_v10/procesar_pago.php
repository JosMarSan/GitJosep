<?php
session_start();

// Verificar que el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    // Si no ha iniciado sesión, redirigir al usuario a la página de inicio de sesión
    header("Location: index.html");
    exit;
}

// Obtener los datos del pago desde el formulario
$tarjeta = $_POST['tarjeta'] ?? '';
$cvv = $_POST['cvv'] ?? '';

// Obtener los datos del carrito desde la sesión
$carrito = $_SESSION['carrito'] ?? [];

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$datbasename = "Info_C360";
$charset = 'utf8mb4';

$conn = mysqli_init();
mysqli_real_connect($conn, $servername, $username, $password, $datbasename);
mysqli_set_charset($conn, $charset);

// Insertar los datos de la compra en la tabla pagos_productos
$sql = "INSERT INTO pagos_productos (numero_tarjeta, cvv) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "is", $tarjeta, $cvv);
$tarjeta = $tarjeta ?? '';
$cvv = $cvv ?? '';
mysqli_stmt_execute($stmt);

// Obtener el ID de la compra recién insertada
$compra_id = mysqli_insert_id($conn);

// Cerrar la conexión a la base de datos
mysqli_close($conn);

// Redirigir al usuario a la página de confirmación de compra
header("Location: pago_realizado.php");
exit;
?>