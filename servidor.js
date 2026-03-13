// servidor.js
// Backend del oráculo — Express + OpenAI
// Arrancar con: node servidor.js

require('dotenv').config();

const express = require('express');
const cors    = require('cors');
const OpenAI  = require('openai');

const app    = express();
const puerto = process.env.PORT || 3000;
const modelo = process.env.OPENAI_MODEL || 'gpt-3.5-turbo';

const openai = new OpenAI({
    apiKey: process.env.OPENAI_API_KEY
});

// Permitir peticiones desde el mismo equipo (XAMPP en localhost)
app.use(cors({ origin: ['http://localhost', 'http://127.0.0.1'] }));
app.use(express.json());


// GET / — comprobación rápida de que el servidor está vivo
app.get('/', (req, res) => {
    res.json({ estado: 'ok', mensaje: 'Servidor del oráculo activo.' });
});


// POST /api/consultar-genio — endpoint principal del oráculo
app.post('/api/consultar-genio', async (req, res) => {
    const pregunta = req.body?.pregunta?.trim();

    // El frontend usa '__ping__' para comprobar que el servidor responde
    if (!pregunta || pregunta === '__ping__') {
        return res.json({ respuesta: 'pong' });
    }

    if (!process.env.OPENAI_API_KEY || process.env.OPENAI_API_KEY === 'sk-...') {
        return res.status(503).json({
            error: 'Falta configurar OPENAI_API_KEY en el archivo .env'
        });
    }

    try {
        const chat = await openai.chat.completions.create({
            model: modelo,
            messages: [
                {
                    role: 'system',
                    content:
                        'Eres el Mago de la Junta de Pelican Town, del juego Stardew Valley. ' +
                        'Respondes preguntas sobre el juego con un tono misterioso y sabio, ' +
                        'en español, de forma breve (máximo 3 frases).'
                },
                {
                    role: 'user',
                    content: pregunta
                }
            ]
        });

        const respuesta = chat.choices[0].message.content;
        res.json({ respuesta });

    } catch (error) {
        console.error('Error OpenAI:', error.message);
        res.status(500).json({
            error: 'El portal mágico ha fallado.',
            detalle: error.message
        });
    }
});


app.listen(puerto, () => {
    console.log(`Oráculo escuchando en http://localhost:${puerto}`);
    console.log(`Modelo: ${modelo}`);
});
