function abrirPanel(seccion) {
    const panel = document.getElementById('panel');
    const contenido = document.getElementById('contenido-panel');
    let html = '';

    switch(seccion) {
        case 'menu':
            html = `
                <div class="menu-opciones">
                    <button onclick="abrirPanel('inicio')"><span><i class="fas fa-home"></i> Inicio</span><i class="fas fa-chevron-right flecha"></i></button>
                    <button onclick="abrirPanel('almacen')"><span><i class="fas fa-box"></i> Iniciar sesión Almacén</span><i class="fas fa-chevron-right flecha"></i></button>
                    <button onclick="abrirPanel('bienes')"><span><i class="fas fa-cogs"></i> Iniciar sesión Bienes y Equipos</span><i class="fas fa-chevron-right flecha"></i></button>
                </div>
            `;
            break;
        case 'inicio':
            window.location.href = "inicio.html";
            break;
        case 'almacen':
            window.location.href = "inicio_sesion_almacen.html";
            break;
        case 'bienes':
            window.location.href = "inicio_sesion_bienes.html";
            break;
        case 'nuevo':
            html = `<h2>Nuevo Usuario</h2><p>Formulario para registrar nuevo usuario.</p>`;
            break;
        default:
            html = `<h2>Sección no disponible</h2>`;
    }

    contenido.innerHTML = html;
    panel.classList.add('abierto');
}

function cerrarPanel() {
    document.getElementById('panel').classList.remove('abierto');
    window.location.href = "inicio.html"; 
}



