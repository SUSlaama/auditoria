<?php
session_start(); 
$conexion = new mysqli("localhost", "root", "", "m3racha");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$mensaje = ""; // Variable para almacenar el mensaje

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if (!empty($usuario) && !empty($password)) {
				// Inyeccion SQL
        $sql = "SELECT idUsuario, usuario, password, rol FROM usuarios WHERE usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            if (password_verify($password, $fila['password'])) {
                $_SESSION['usuario'] = $usuario; 
                $_SESSION['rol'] = $fila['rol'];
                if ($fila['rol'] == 'admin') {
                    header("Location: admin.php");
                    exit();
                } else {
                    header("Location: index.php");
                    exit();
                }
            } else {
                $mensaje = "Usuario o contraseña incorrectos.";
            }
        } else {
            $mensaje = "Usuario o contraseña incorrectos.";
        }
    } else {
        $mensaje = "Por favor, ingrese usuario y contraseña.";
    }
}
?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>

<body>
    
    <div id="notification" style="display:none; position:fixed; top:10px; right:10px; background:#323232; color:#fff; padding:15px; border-radius:5px; z-index:1000;">
        <span id="notification-message"></span>
    </div>



    <div class="login-container">
        <div class="logo">
            <img src="img/m3.png" alt="Logo">
        </div>
        <h2>Iniciar sesión</h2>

        <!-- Formulario de login -->
        <form action="login.php" method="POST">
            <input type="text" name="usuario" class="input-field" placeholder="Usuario" required>
            <input type="password" name="password" class="input-field" placeholder="Contraseña" required>

            <!-- Mostrar mensaje de error -->
            <div class="error-message">
                <!-- Aquí puedes insertar el mensaje de error dinámicamente con PHP -->
            </div>

            <button type="submit" class="btn-login">Iniciar sesión</button>
        </form>

        <!-- Enlaces de recuperación -->
        <div class="links">
            <a href="#">¿Olvidaste tu contraseña?</a><br>
            <a href="#">Registrarse</a>
        </div>
    </div>

    <script>
        function showNotification(message) {
            const notification = document.getElementById('notification');
            const messageSpan = document.getElementById('notification-message');

            messageSpan.textContent = message;
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none';
            }, 4000);
        }
    </script>

<?php if (!empty($mensaje)) : ?>
    <script>
        showNotification("<?= $mensaje ?>");
    </script>
<?php endif; ?>

</body>

</html>