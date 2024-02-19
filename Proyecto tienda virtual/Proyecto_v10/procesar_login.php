<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Info_C360";

// Crear conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar si la conexión a la base de datos fue exitosa
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verificar si es una solicitud HTTP antes de procesar los datos del formulario
$request_method = $_SERVER["REQUEST_METHOD"] ?? "";

if ($request_method == "POST") {
    // Obtener los datos del formulario
    $correo_electronico = $_POST["correo"] ?? "";
    $contrasena = $_POST["contrasena"] ?? "";

    // Verificar que los campos del formulario no estén vacíos
    if (empty($correo_electronico)) {
        echo "El campo 'correo' es obligatorio";
    } elseif (empty($contrasena)) {
        echo "El campo 'contraseña' es obligatorio";
    } else {
        // Preparar la consulta SQL
        $stmt = mysqli_prepare($conn, "SELECT id_usuario, contrasena FROM usuarios WHERE correo = ?");
        mysqli_stmt_bind_param($stmt, "s", $correo_electronico);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id_usuario, $contrasena_db);

        // Verificar si la consulta SQL devolvió una fila
        if (mysqli_stmt_fetch($stmt)) {
            // Verificar que la contraseña proporcionada coincida con la almacenada en la base de datos
            if (password_verify($contrasena, $contrasena_db)) {
                // Iniciar sesión para el usuario autenticado
                $_SESSION["usuario"] = $id_usuario;
                // Redirigir al usuario a la página de bienvenida
                header("Location: bienvenida.php");
                exit();
            } else {
                header("Location: inicio1.html");
            }
        } else {
            header("Location: inicio2.html");
        }

        // Cerrar el statement
        mysqli_stmt_close($stmt);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>