function toggleSeccion(seccionId) {
    var seccion = document.getElementById(seccionId);
    var flecha = seccion.previousElementSibling.querySelector('.flecha');
    if (seccion.style.display === 'none') {
        seccion.style.display = 'block';
        flecha.style.transform = 'rotate(-180deg)';
    } else {
        seccion.style.display = 'none';
        flecha.style.transform = 'rotate(0deg)';
    }
}

// Inicializar todas las secciones desplegables
document.addEventListener('DOMContentLoaded', function() {
    var secciones = document.querySelectorAll('.seccion .contenido');
    secciones.forEach(function(seccion) {
        seccion.style.display = 'none';
    });
});


// Función para mostrar la imagen en primer plano
function mostrarImagen(src) {
    const imagenAmpliada = document.getElementById('imagen-ampliada');
    const imagenPrimerPlano = document.getElementById('imagen-primer-plano');

    imagenAmpliada.src = src;
    imagenPrimerPlano.style.display = 'block';
}

// Función para cerrar la imagen en primer plano
function cerrarImagen() {
    const imagenPrimerPlano = document.getElementById('imagen-primer-plano');
    imagenPrimerPlano.style.display = 'none';
}