/**
 * motor-logico.js
 * Gestiona el flujo de datos entre la UI y la API de OpenAI
 */

const OraculoConfig = {
    output: document.getElementById('consola-salida'),
    input: document.getElementById('input-mico'),
    btn: document.getElementById('lanzar-hechizo'),
    isProcess: false
};

const gestionarPeticion = async () => {
    const prompt = OraculoConfig.input.value.trim();

    if (!prompt || OraculoConfig.isProcess) return;

    // Bloqueo de seguridad para no duplicar gastos en la API
    OraculoConfig.isProcess = true;
     OraculoConfig.btn.disabled = true;
    
    prepararEscena();

    try {
        // AQUÍ CONECTARÁS TU ENDPOINT DE OPENAI
        // Simulo latencia de red para validar el estado de carga
        const respuestaRaw = await simularLlamadaAPI(prompt);
        escribirEfectoTeletipo(respuestaRaw);
    } catch (err) {
         OraculoConfig.output.innerHTML = `<span class="text-danger">Error místico: ${err.message}</span>`;
    } finally {
        OraculoConfig.isProcess = false;
        OraculoConfig.btn.disabled = false;
        OraculoConfig.input.value = '';
    }
};

function prepararEscena() {
     OraculoConfig.output.innerHTML = '<div class="spinner-grow text-warning spinner-grow-sm"></div> Consultando los astros...';
}

function escribirEfectoTeletipo(texto) {
    let i = 0;
     OraculoConfig.output.innerHTML = ''; 
    const intervalo = setInterval(() => {
         OraculoConfig.output.innerHTML += texto.charAt(i);
        i++;
        if (i > texto.length) clearInterval(intervalo);
    }, 30); // Velocidad de escritura humana
}

// motor-logico.js - Actualizado para conexión real
async function llamarAlOraculoReal(preguntaUsuario) {
    const respuestaServidor = await fetch('http://localhost:3000/api/consultar-genio', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ pregunta: preguntaUsuario })
    });

    if (!respuestaServidor.ok) throw new Error("El portal está cerrado.");
    
    const data = await respuestaServidor.json();
    return data.respuesta;
}

// Listener con nomenclatura moderna
OraculoConfig.btn.addEventListener('click', gestionarPeticion);
OraculoConfig.input.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') gestionarPeticion();
});