 <?php

    if (!defined('CLIENT_ID')) {
        define("CLIENT_ID", "AamBPLpv0PQb7OtDAttavG3QdqSABMbZE4DVlYul1QX3ovW9pS5vSsoUpR4mYS-rTE-0rMEcfV5WBCi9");
    }

    if (!defined('CURRENCY')) {
        define("CURRENCY", "MXN");
    }

    if (!defined('KEY_TOKEN')) {
        define("KEY_TOKEN", "ME QUIERO MIMIR");
    }

    if (!defined('MONEDA')) {
        define("MONEDA", "$");
    }
    

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    

    $num_cart = 0;
    if (isset($_SESSION['carrito']['producto'])){
        $num_cart = count($_SESSION['carrito']['producto']);
    }
?>