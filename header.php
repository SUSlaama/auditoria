<?php
define('BASE_URL', '/auditoria/');
require 'config/config.php';
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

    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-M0GLMNS9FJ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-M0GLMNS9FJ');
</script>

</head>
<body>
    <header class="header">
        <!-- Barra de navegación -->
        <nav class="navbar">
            <div class="menu-icon">
                <a href='<?php echo BASE_URL; ?>'>
                    <img src="<?php echo BASE_URL; ?>img/m3.png" class="logo-menu">
                </a>
            </div>
            <div class="search-bar">
                <!-- Barra de búsqueda -->
                <form id="search-form" action="<?php echo BASE_URL; ?>Busqueda.php" method="GET">
                    <i class="fas fa-search" id="search-icon"></i>
                    <input type="text" name="q" id="search-input" placeholder="SEARCH">
                </form>
            </div>
            <div class="nav-links">
                <!-- Enlaces de navegación -->
                <a href="<?php echo BASE_URL; ?>clothes.php">CLOTHES</a>
                <a href="<?php echo BASE_URL; ?>photocards.php">PHOTOCARDS</a>
                <a href="<?php echo BASE_URL; ?>albums.php">ALBUMS</a>
                <a href="<?php echo BASE_URL; ?>more.php">MORE....</a>
            </div>
            <div class="nav-icons">
                <!-- Iconos de carrito y usuario -->
                <a href="checkout.php" id="carrito-icono"><span id ="num_cart"><?php echo $num_cart ?></span>
                    <i class="fas fa-shopping-cart"></i>
                </a>

            </div>
        </nav>
    </header>

    <div class="discount-banner">
        <p class='banner-text'>40% de descuento por Black Friday - ¡Compra ahora!</p>
    </div>
</body>
</html>
