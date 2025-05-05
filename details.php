<?php
define('BASE_URL', '/');
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();  

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id== '' || $token == ''){
    echo 'Error al procesar la peticion';
    exit;
}else{
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp){

        $sql = $con->prepare("SELECT count(idProducto) FROM producto where idProducto=? ");
        $sql->execute([$id]);
        if($sql->fetchColumn() >0){

            $sql = $con->prepare("SELECT nombre, descripcion, precio, img FROM producto where idProducto=?");
            $sql->execute([$id]);
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);

            $nombre = $resultado['nombre'];
            $descripcion = $resultado['descripcion'];
            $precio = $resultado['precio'];
            $img = $resultado['img'];
            
        }




    }else{
        echo 'Error al procesar la peticion';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php $nombre ?></title>
    <link rel="stylesheet" href="CSS/estilosProducts.css">
    <link rel="stylesheet" href="CSS/estilos.css">
    <link rel="stylesheet" href="CSS/userEstilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&;200;400;500;600;700display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200;300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;600;700&display=swap" rel="stylesheet"> 
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
                <a href="<?php echo BASE_URL; ?>more.php">MORE...</a>
            </div>
            <div class="nav-icons">
                <!-- Iconos de carrito y usuario -->
                <a href="checkout.php" id="carrito-icono"><span id ="num_cart"><?php echo $num_cart ?></span>
                    <i class="fas fa-shopping-cart"></i>
                </a>

            </div>
        </nav>
    </header>    

<!-- ------------------------------------------------------------------------------------------------ -->

    <div class="contenedor-productPage">
        <div class="productPage-imagen">
            <!-- Aquí va tu imagen del producto -->
            <img src='<?php echo $img ?>' alt='<?php echo $nombre ?>'>
            
        </div>
        <div class="productPage-informacion">
        <!-- Titulo del producto -->
        <?php echo "<h1 class='name'>$nombre</h1>";?> 
        <p class='precio'><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></p>
        <!-- Tallas disponibles -->
<!-- Estructura de los radio buttons -->
            <p class="tallasP">Tallas</p>
            <div class="tallas">
                <input type="radio" id="tallaCH" name="talla" value="CH" checked>
                <label for="tallaCH">CH</label>

                <input type="radio" id="tallaMD" name="talla" value="MD">
                <label for="tallaMD">MD</label>

                <input type="radio" id="tallaGD" name="talla" value="GD">
                <label for="tallaGD">GD</label>

                <input type="radio" id="tallaXGD" name="talla" value="XGD">
                <label for="tallaXGD">XGD</label>
            </div>

        <!-- Botón para agregar al carrito -->
        <button class='agregar' onclick="addProducto(<?php echo $id;?>, '<?php echo $token_tmp; ?>')">AGREGAR</button>
            

            <a href="#" class="imagen-enlace" onclick="mostrarImagen('img/tallas.jpg')">Guía de tallas</a>

    <!-- Contenedor de la imagen en primer plano -->
            <div class="imagen-primer-plano" id="imagen-primer-plano">
                <span class="cerrar" onclick="cerrarImagen()">&times;</span>
                <img src="" alt="" id="imagen-ampliada">
            </div>

        <!-- Secciones desplegables para la descripción, envíos, etc. -->
            <div class="seccion">
                <h2 onclick="toggleSeccion('descripcion')">Descripción<span class="flecha">&#9660;</span></h2>
                <div class="contenido" id="descripcion">
                <!-- Contenido de la descripción -->
                <p><?php echo $descripcion ?></p>
                </div>
            </div>
            <div class="seccion">
                <h2 onclick="toggleSeccion('envios')">Envíos <span class="flecha">&#9660;</span></h2>
                <div class="contenido" id="envios">
                <!-- Contenido de envíos -->
                <p>Envío gratis a partir de pedidos de $199.00. Los costos de</p>
                <p>envíos y días hábiles de entrega están sujetos a la paquetería<br> que selecciones.</p>
                </div>
            </div>
            <div class="seccion">
                <h2 onclick="toggleSeccion('cambios')">Cambios y devoluciones <span class="flecha">&#9660;</span></h2>
                <div class="contenido" id="cambios">
                <!-- Contenido de envíos -->
                <p>Dispones de un plazo de 30 días naturales a partir de la fecha</p>
                <p>en la que recibiste tu pedido para solicitar una devolución. Si</p>
                <p>realizas tu devolución con paquetería, una vez recibamos los</p>
                <p>artículos en nuestro centro de distribución, verificaremos que</p>
                <p>artículos se encuentran en óptimas condiciones y no muestran</p>
                <p>signos de haber sido utilizados. Una vez inspeccionado y con</p>
                <p>valoración positiva procederemos a iniciar el reembolso, el</p>
                <p>cual te notificaremos vía email para qué puedas hacer</p>
                <p>seguimiento.</p>
                <p>No se permiten cambios a través del servicio de paquetería</p>
                <p>solo a través del contacto con la página oficial y dependiendo</p>
                <p>de stock.</p>
                <p>Si recibes un producto defectuoso o dañado, por favor,</p>
                <p>contáctanos de inmediato a través de nuestro servicio de</p>
                <p>Atención al cliente y te proporcionaremos instrucciones específicas</p>
                <p>para resolver el problema.</p>
                <p></p>

                </div>
            </div>
        </div>
    </div>

<script src="script.js"></script>
<script>
    function addProducto(id, token){
        let url = 'clases/carrito.php'
        let formData = new FormData()
        formData.append('id', id)
        formData.append('token', token)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json()).then(data =>{
            if(data.ok){
                let elemento = document.getElementById("num_cart")
                elemento.innerHTML = data.numero
            }
        })
    }
</script>
</body>

    <?php
    // Incluye el footer en la página actual
    include('footer.php');
    ?>
</html>