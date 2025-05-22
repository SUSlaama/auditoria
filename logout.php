<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_unset();     // Limpia todas las variables de sesión
session_destroy();   // Destruye la sesión
header("Location: index.php"); // O redirige al inicio
exit();
?>
