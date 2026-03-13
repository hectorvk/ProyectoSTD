// caché de edificios para la sesión — cambia solo si el admin modifica la tabla
let catalogoEdificios = [];

// Orden deliberado: materiales más baratos primero, iridio al final
// Si se añade una columna nueva a la tabla, se añade aquí también
const COLUMNAS_MATERIALES = [
    { col: 'cant_madera',          label: 'Madera' },
    { col: 'cant_piedra',          label: 'Piedra' },
    { col: 'cant_madera_noble',    label: 'Madera Noble' },
    { col: 'cant_fibra',           label: 'Fibra' },
    { col: 'cant_arcilla',         label: 'Arcilla' },
    { col: 'cant_lingote_cobre',   label: 'Lingote de Cobre' },
    { col: 'cant_lingote_hierro',  label: 'Lingote de Hierro' },
    { col: 'cant_lingote_iridio',  label: 'Lingote de Iridio' },
    { col: 'cant_cuarzo_refinado', label: 'Cuarzo Refinado' },
];

function cargarCatalogoEdificios() {
    const selectorEdificio = document.getElementById("edificio");

    fetch('api/get_edificios.php')
        .then(r => {
            if (!r.ok) throw new Error(`HTTP ${r.status} — get_edificios.php devolvió error`);
            return r.json();
        })
        .then(listaEdificios => {
            catalogoEdificios = listaEdificios;
            selectorEdificio.innerHTML = "";

            if (!catalogoEdificios.length) {
                selectorEdificio.innerHTML = "<option value=''>Sin edificios en BD</option>";
                return;
            }

            catalogoEdificios.forEach(ed => {
                const op = document.createElement("option");
                op.value = ed.id;
                op.text = ed.nombre ?? 'Edificio sin nombre';
                selectorEdificio.appendChild(op);
            });
        })
        .catch(err => {
            console.error("No se pudo cargar el catálogo de edificios:", err.message);
            selectorEdificio.innerHTML = "<option value=''>Error cargando BD</option>";
        });
}

function calcularCosteObra() {
    const idEdificio    = parseInt(document.getElementById('edificio').value, 10);
    const cantidadObras = parseInt(document.getElementById("cantidad").value, 10);

    if (isNaN(idEdificio))                              return { error: "Selecciona un edificio." };
    if (isNaN(cantidadObras) || cantidadObras < 1)      return { error: "La cantidad debe ser mayor a 0." };

    const planoEdificio = catalogoEdificios.find(e => parseInt(e.id, 10) === idEdificio);
    if (!planoEdificio) return { error: "Edificio no encontrado en catálogo." };

    const costeOroPorUnidad    = parseInt(planoEdificio.coste_oro, 10)            || 0;
    const jornadasConstruccion = parseInt(planoEdificio.tiempo_construccion, 10)  || 0;

    // Filtramos materiales con total 0 — no tiene sentido mostrar "Fibra: 0" en pantalla
    const materialesRequeridos = COLUMNAS_MATERIALES
        .map(m => ({ label: m.label, total: (parseInt(planoEdificio[m.col], 10) || 0) * cantidadObras }))
        .filter(m => m.total > 0);

    return {
        nombreEdificio:    planoEdificio.nombre,
        cantidadObras,
        oroTotalRequerido: costeOroPorUnidad * cantidadObras,
        jornadasConstruccion,
        materialesRequeridos,
        // otros_materiales viene como texto libre introducido por el admin — se pasa sin procesar
        notaMateriales: planoEdificio.otros_materiales ?? null,
    };
}

window.addEventListener("DOMContentLoaded", () => {
    cargarCatalogoEdificios();

    document.getElementById("btnCalcular").addEventListener("click", () => {
        const planObra        = calcularCosteObra();
        const panelResultados = document.getElementById("resultados");

        if (planObra.error) {
            panelResultados.innerHTML = `<p class="error-msg">${planObra.error}</p>`;
            return;
        }

        const materialesHTML = planObra.materialesRequeridos.length
            ? planObra.materialesRequeridos.map(m => `<p><strong>${m.label}:</strong> ${m.total}</p>`).join('')
            : '<p>Este edificio no requiere materiales estándar.</p>';

        const otrosHTML = planObra.notaMateriales
            ? `<p><strong>Materiales extra:</strong> ${planObra.notaMateriales}</p>`
            : '';

        panelResultados.innerHTML = `
            <p><strong>Edificio:</strong> ${planObra.nombreEdificio}</p>
            <p><strong>Cantidad:</strong> ${planObra.cantidadObras}</p>
            <p><strong>Oro total:</strong> ${planObra.oroTotalRequerido.toLocaleString('es-ES')}G</p>
            <p><strong>Construcción:</strong> ${planObra.jornadasConstruccion} jornada(s) por edificio</p>
            <hr style="border-color:#8b4513;">
            <p><strong>Materiales:</strong></p>
            ${materialesHTML}
            ${otrosHTML}
        `;
    });
});
