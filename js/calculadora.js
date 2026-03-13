// bdCultivos actúa como caché local para la sesión — la API no tiene paginación
// y el catálogo de cultivos no cambia en tiempo real (solo el admin lo modifica)
let bdCultivos = [];

function iniciarVista() {
    const selectorCultivo = document.getElementById("cultivo");

    fetch('api/get_cultivos.php')
        .then(r => {
            // r.ok false aquí es casi siempre un 500 del servidor, no un fallo de red
            if (!r.ok) throw new Error(`HTTP ${r.status} — el endpoint de cultivos no respondió`);
            return r.json();
        })
        .then(cosechasDisponibles => {
            bdCultivos = cosechasDisponibles;
            selectorCultivo.innerHTML = "";

            // BD vacía es válido técnicamente pero raro — significa que el admin limpió la tabla
            if (!bdCultivos.length) {
                selectorCultivo.innerHTML = "<option value=''>Sin cultivos en BD</option>";
                return;
            }

            bdCultivos.forEach(cultivo => {
                const op = document.createElement("option");
                op.value = cultivo.id;
                op.text = cultivo.nombre ?? 'Cultivo sin nombre';
                selectorCultivo.appendChild(op);
            });
        })
        .catch(err => {
            // No lanzamos alert() — en producción sería molesto. Console es suficiente en dev
            console.error("Fallo cargando cultivos desde BD:", err.message);
            selectorCultivo.innerHTML = "<option value=''>Error cargando BD</option>";
        });
}

function calcularTemporadaCultivo() {
    const selectorCultivo = document.getElementById('cultivo');
    const idCultivoSeleccionado = parseInt(selectorCultivo.value, 10);
    const diaPlantacion         = parseInt(document.getElementById("dia").value, 10);
    const cantidadSemillas      = parseInt(document.getElementById("semillas").value, 10);

    if (isNaN(idCultivoSeleccionado)) return { error: "Falta seleccionar cultivo." };
    if (isNaN(diaPlantacion) || diaPlantacion < 1 || diaPlantacion > 28) return { error: "Día fuera de rango (1–28)." };
    if (isNaN(cantidadSemillas) || cantidadSemillas < 1) return { error: "Se necesita al menos 1 semilla." };

    const cultivoTarget = bdCultivos.find(c => parseInt(c.id, 10) === idCultivoSeleccionado);
    if (!cultivoTarget) return { error: "El cultivo seleccionado ya no existe en BD." };

    const precioPorSemilla  = parseFloat(cultivoTarget.precio_semilla)     ?? 0;
    const precioVentaUnidad = parseFloat(cultivoTarget.precio_venta)        ?? 0;
    const diasCrecimiento   = parseInt(cultivoTarget.tiempo_crecimiento, 10) || 0;
    const diasRegreso       = parseInt(cultivoTarget.tiempo_regreso, 10)    || 0;
    // rendimiento_por_cosecha no existe en el schema actual — fallback a 1
    // cuando se añada la columna, este || 1 lo recoge sin tocar nada más
    const rendimientoCosecha = parseFloat(cultivoTarget.rendimiento_por_cosecha) || 1;

    const diasRestantesTemp = 28 - diaPlantacion;
    let numeroCosechas = 0;

    if (diasRestantesTemp >= diasCrecimiento) {
        // Cultivos sin regreso (diasRegreso === 0) solo cosechan una vez aunque queden días libres
        numeroCosechas = diasRegreso === 0
            ? 1
            : 1 + Math.floor((diasRestantesTemp - diasCrecimiento) / diasRegreso);
    }

    const inversionTotal = cantidadSemillas * precioPorSemilla;
    const ingresoBruto   = numeroCosechas * cantidadSemillas * rendimientoCosecha * precioVentaUnidad;
    const beneficioNeto  = ingresoBruto - inversionTotal;
    // Si no hubo cosechas no tiene sentido económico dividir entre días — devolvemos 0
    const oroXDia = numeroCosechas > 0 ? (beneficioNeto / diasRestantesTemp).toFixed(2) : 0;

    return { numeroCosechas, inversionTotal, ingresoBruto, beneficioNeto, oroXDia };
}

window.addEventListener("DOMContentLoaded", () => {
    iniciarVista();

    document.getElementById("btnCalcular").addEventListener("click", () => {
        const resCalculo    = calcularTemporadaCultivo();
        const panelResultados = document.getElementById("resultados");

        if (resCalculo.error) {
            panelResultados.innerHTML = `<p class="error-msg">${resCalculo.error}</p>`;
            return;
        }

        panelResultados.innerHTML = `
            <p><strong>Cosechas:</strong> ${resCalculo.numeroCosechas}</p>
            <p><strong>Inversión:</strong> ${resCalculo.inversionTotal}G</p>
            <p><strong>Bruto:</strong> ${resCalculo.ingresoBruto}G</p>
            <p><strong>Neto:</strong> ${resCalculo.beneficioNeto}G</p>
            <p><strong>Oro/Día:</strong> ${resCalculo.oroXDia}G/D</p>
        `;
    });
});
