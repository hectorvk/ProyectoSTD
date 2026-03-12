<?php
// Solo usuarios logueados pueden ver esta página
require('hasLoginProyectoStardew.php');
$usuario = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablón de la Villa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilosProyectoStardew.css">
    <link rel="stylesheet" href="stdStilo.css">
    <link rel="stylesheet" href="css/tablon.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand fw-bold" href="homeProyectoStardew.php">Proyecto Stardew</a>
        <div class="navbar-nav ms-auto gap-2">
            <a class="nav-link text-white" href="index.php">Calculadoras</a>
            <a class="nav-link text-white" href="personajesProyectoStardew.php">Vecinos</a>
            <a class="nav-link text-white" href="materialesProyectoStardew.php">Materiales</a>
            <a class="nav-link text-white" href="tablonProyectoStardew.php">Tablón</a>
            <a class="nav-link text-white" href="perfilProyectoStardew.php">Mi Perfil</a>
            <a class="nav-link text-white" href="logoutProyectoStardew.php">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-4">

    <!-- Noticias oficiales de Steam -->
    <section class="tablon-pierre-wrapper mb-5">
        <div class="banner-invocacion">Diario de la Villa</div>

        <div class="text-center mb-4">
            <h2 class="h5 fw-bold mb-1 titulo-noticia">Últimas Noticias de Stardew Valley</h2>
            <p class="text-muted small mb-0">Parches y actualizaciones oficiales desde Steam</p>
        </div>

        <div id="contenedor-noticias" class="row g-4">
            <div class="col-12 text-center py-4">
                <div class="spinner-grow spinner-noticias" role="status"></div>
                <p class="mt-2 text-muted">Buscando cartas en el buzón...</p>
            </div>
        </div>
    </section>

    <!-- Chat con el oráculo (requiere backend en localhost:3000) -->
    <section class="tablon-pierre-wrapper">
        <div class="banner-invocacion">Secretos de la Villa</div>

        <div class="row">

            <!-- Avatar y estado de conexión -->
            <div class="col-lg-4 text-center border-end border-dark border-opacity-10 mb-3 mb-lg-0">
                <div class="avatar-marco shadow-sm mx-auto">
                    <img src="imagenes/Wizard.png"
                         onerror="this.src='stardew.gif'"
                         class="img-mago"
                         alt="Mago de la Junta">
                </div>
                <p class="small fw-bold mb-1 mt-2 nombre-mago">Mago de la Junta</p>
                <span class="badge badge-conexion" id="badge-estado">
                    <span class="dot-estado" id="dot-estado"></span>
                    Comprobando...
                </span>
                <p class="text-muted mt-2 texto-usuario">
                    Conectado como: <strong><?= $usuario ?></strong>
                </p>
            </div>

            <!-- Consola de respuestas y campo de pregunta -->
            <div class="col-lg-8 ps-lg-4 d-flex flex-column justify-content-between">
                <div class="consola-respuesta" id="consola-salida">
                    <p class="text-muted m-0">El aire se siente cargado de magia... pregunta algo sobre Stardew Valley.</p>
                </div>

                <div>
                    <div class="input-group mb-2">
                        <input type="text"
                               id="campo-pregunta"
                               class="form-control border-dark border-2"
                               placeholder="Ej: ¿Cuándo plantar coliflor?"
                               maxlength="300">
                        <button class="btn btn-preguntar px-4" id="btn-preguntar">
                            Preguntar
                        </button>
                    </div>
                    <small class="text-muted texto-endpoint">
                        Conecta con <code>localhost:3000/api/consultar-genio</code>
                    </small>
                </div>
            </div>

        </div>
    </section>

</div>


<script>
// ── Noticias de Steam ──────────────────────────────────────────

async function cargarNoticias() {
    const idJuego = '413150'; // Stardew Valley en Steam
    const urlRSS  = `https://steamcommunity.com/games/${idJuego}/rss/`;
    const api     = `https://api.rss2json.com/v1/api.json?rss_url=${encodeURIComponent(urlRSS)}`;
    const contenedor = document.getElementById('contenedor-noticias');

    try {
        const res  = await fetch(api);
        if (!res.ok) throw new Error('No se pudo contactar con el servidor de Steam.');

        const data = await res.json();
        if (data.status !== 'ok') throw new Error('La respuesta del servidor no fue válida.');

        // Pequeña pausa para que el spinner no desaparezca de golpe
        setTimeout(() => mostrarNoticias(data.items), 600);

    } catch (error) {
        contenedor.innerHTML = `
            <div class="col-12 text-center">
                <div class="alert shadow-sm border-danger">
                    <h4>¡Vaya!</h4>
                    <p>${error.message}</p>
                    <button class="btn btn-sm btn-outline-danger" onclick="cargarNoticias()">
                        Intentar de nuevo
                    </button>
                </div>
            </div>`;
    }
}

function mostrarNoticias(noticias) {
    const contenedor = document.getElementById('contenedor-noticias');
    contenedor.innerHTML = '';

    noticias.slice(0, 6).forEach(noticia => {
        // Quitamos el HTML del resumen y cortamos a unas 22 palabras
        const resumen = noticia.description
            .replace(/<[^>]*>/gm, '')
            .split(' ').slice(0, 22).join(' ') + '…';

        const fecha = new Date(noticia.pubDate).toLocaleDateString('es-ES', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });

        contenedor.insertAdjacentHTML('beforeend', `
            <div class="col-md-6 col-lg-4">
                <article class="tarjeta-noticia h-100 shadow-sm d-flex flex-column">
                    <div class="cabecera-noticia text-center small">
                        Boletín Oficial · ${fecha}
                    </div>
                    <div class="card-body p-4 flex-grow-1">
                        <h2 class="h5 fw-bold mb-3 titulo-noticia">${noticia.title}</h2>
                        <p class="card-text text-secondary small">${resumen}</p>
                    </div>
                    <div class="p-4 pt-0">
                        <a href="${noticia.link}" target="_blank" rel="noopener"
                           class="btn btn-leer w-100">
                            Leer circular
                        </a>
                    </div>
                </article>
            </div>`);
    });
}


// ── Oráculo / chat IA ──────────────────────────────────────────

const oraculo = {
    consola:    document.getElementById('consola-salida'),
    campo:      document.getElementById('campo-pregunta'),
    boton:      document.getElementById('btn-preguntar'),
    ocupado:    false,
    endpoint:   'http://localhost:3000/api/consultar-genio'
};

// Intenta conectar al backend al cargar la página
async function verificarBackend() {
    const dot   = document.getElementById('dot-estado');
    const badge = document.getElementById('badge-estado');

    try {
        await fetch(oraculo.endpoint, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ pregunta: '__ping__' }),
            signal:  AbortSignal.timeout(3000)
        });
        dot.classList.add('online');
        badge.classList.remove('offline');
        badge.innerHTML = '<span class="dot-estado online"></span> Online';

    } catch (_) {
        dot.classList.add('offline');
        badge.classList.add('offline');
        badge.innerHTML = '<span class="dot-estado offline"></span> Sin backend';
    }
}

async function enviarPregunta() {
    const pregunta = oraculo.campo.value.trim();
    if (!pregunta || oraculo.ocupado) return;

    oraculo.ocupado    = true;
    oraculo.boton.disabled = true;
    oraculo.consola.innerHTML =
        '<div class="spinner-grow text-warning spinner-grow-sm me-2"></div>' +
        '<em>Consultando los astros…</em>';

    try {
        const res  = await fetch(oraculo.endpoint, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ pregunta })
        });

        if (!res.ok) throw new Error(`El portal está cerrado (HTTP ${res.status}).`);

        const data     = await res.json();
        const respuesta = data.respuesta ?? JSON.stringify(data);

        // Efecto teletipo para que no aparezca todo de golpe
        let i = 0;
        oraculo.consola.innerHTML = '';
        const tick = setInterval(() => {
            oraculo.consola.innerHTML += respuesta.charAt(i++);
            if (i >= respuesta.length) clearInterval(tick);
        }, 25);

    } catch (error) {
        oraculo.consola.innerHTML =
            `<span class="text-danger fw-bold">Error:</span> ${error.message}<br>
             <small class="text-muted">
                 ¿Está arrancado el servidor en <code>localhost:3000</code>?
             </small>`;
    } finally {
        oraculo.ocupado        = false;
        oraculo.boton.disabled = false;
        oraculo.campo.value    = '';
    }
}

oraculo.boton.addEventListener('click', enviarPregunta);
oraculo.campo.addEventListener('keypress', e => {
    if (e.key === 'Enter') enviarPregunta();
});


// ── Arranque ──────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
    cargarNoticias();
    verificarBackend();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
