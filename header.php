<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
define('BASE_URL', '/auditoria/');
require 'config/config.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>M-3RACHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-M0GLMNS9FJ');
    </script>
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="menu-icon">
                <a href='<?php echo BASE_URL; ?>'>
                    <img src="<?php echo BASE_URL; ?>img/m3.png" class="logo-menu">
                </a>
            </div>
            <div class="search-bar">
                <form id="search-form" action="<?php echo BASE_URL; ?>Busqueda.php" method="GET">
                    <i class="fas fa-search" id="search-icon"></i>
                    <input type="text" name="q" id="search-input" placeholder="SEARCH">
                </form>
            </div>
            <div class="nav-links">
                <a href="<?php echo BASE_URL; ?>clothes.php">CLOTHES</a>
                <a href="<?php echo BASE_URL; ?>photocards.php">PHOTOCARDS</a>
                <a href="<?php echo BASE_URL; ?>albums.php">ALBUMS</a>
                <a href="<?php echo BASE_URL; ?>more.php">MORE....</a>

                <!-- Mostrar INICIAR SESION o CERRAR SESION según el estado de sesión -->
                <?php if (isset($_SESSION['usuario'])): ?>
                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                        <a href="<?php echo BASE_URL; ?>admin.php">ADMIN</a> |
                    <?php endif; ?>
                    <a href="<?php echo BASE_URL; ?>logout.php">CERRAR SESION</a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>login.php">INICIAR SESION</a>
                <?php endif; ?>

            </div>
            <div class="nav-icons">
                <a href="checkout.php" id="carrito-icono"><span id="num_cart"><?php echo $num_cart ?></span>
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