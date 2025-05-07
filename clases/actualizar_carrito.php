<?php 
session_start();
require '../config/config.php';
require '../config/database.php';

$datos = ['ok' => false];

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'eliminar' && isset($_POST['id'])) {
        $id = $_POST['id'];

        // $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (isset($_SESSION['carrito']['producto'][$id])) {
            unset($_SESSION['carrito']['producto'][$id]);
            $datos['ok'] = true;
        }

    } elseif ($action == 'agregar' && isset($_POST['id']) && isset($_POST['cantidad'])) {
        $id = $_POST['id'];
        $cantidad = $_POST['cantidad'];

        // Validar y sanitizar la cantidad , para inputs de usuario
        $cantidad = filter_var($cantidad, FILTER_SANITIZE_NUMBER_INT);

        if ($cantidad > 0) {
            if (isset($_SESSION['carrito']['producto'][$id])) {
                $_SESSION['carrito']['producto'][$id] = $cantidad;
                $datos['ok'] = true;
            }
        }
    }
}
header('Content-Type: application/json');
echo json_encode($datos); // Enviar respuesta
?>