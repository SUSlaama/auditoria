<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atención a clientes - M-3RACHA</title>

    <link rel="stylesheet" href="CSS/atencionClientes.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;600;700&display=swap" rel="stylesheet">

</head>
<body>

    <?php include 'header.php'; ?>

    <main class="atencion-container">

        <h1>Atención a clientes</h1>

        <section class="atencion-section preguntas-frecuentes">
            <h2>Preguntas Frecuentes</h2>
            <p>¿Por que Stray Kids?</p>
            <p>¿Algún día seré tan cool como ustedes?</p>
            <p>¿Si?</p>
        </section>

        <section class="atencion-section formulario-contacto">
            <h2>¿Tienes alguna duda?</h2>
            <form id="form-contacto" method="post" action="procesar_contacto.php">
                <textarea name="mensaje" placeholder="Cuentanos todo" required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </section>

        <section class="atencion-section info-contacto">
            <h2>CONTACTO DE ATENCIÓN A CLIENTES</h2>
            <p>
                Número de teléfono: 449-897-56-89
            </p>
            <p>
                Correo: atencionalclientes@m3racha.com
            </p>
        </section>

    </main>

    <div id="confirmationModal" class="modal-overlay">
        <div class="modal-box">
            <p id="modalMessage">¡Mensaje enviado con éxito!</p>
            <p><small>Serás redirigido a la página de inicio...</small></p>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('form-contacto');
        const modal = document.getElementById('confirmationModal');

        form.addEventListener('submit', function(event) {
        event.preventDefault();
        modal.classList.add('visible');

        setTimeout(function() {
            window.location.href = 'index.php';
        }, 3000);
    });

    });
    </script>

</body>
</html>
