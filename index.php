<?php
require 'config/database.php';
require 'config/config.php';
$db = new Database();
$con = $db->conectar();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>M-3RACHA</title>
    <link rel="stylesheet" href="CSS/estilos.css">
    <link rel="stylesheet" href="CSS/userEstilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'header.php' ?>



    <div class="slogan-container">
        <img src="img/slogan.PNG" alt="slogan">
    </div>


    <div class="portada-container">
        <img src="img/Portada.png" alt="Portada">
    </div>
    </div>

    <?php
    // Incluye el footer en la página actual
    include('footer.php');
    ?>
</body>

</html>