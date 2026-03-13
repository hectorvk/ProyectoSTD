import express from "express";
import cors from "cors";
import dotenv from "dotenv";
import OpenAI from "openai";

dotenv.config();

const app = express();
app.use(cors());
app.use(express.json());

const openai = new OpenAI({
 apiKey: process.env.OPENAI_API_KEY
});

app.post("/api/consultar-genio", async (req, res) => {

 const pregunta = req.body.pregunta;

 if (pregunta === "__ping__") {
  return res.json({ estado: "ok" });
 }

 try {

  const completion = await openai.chat.completions.create({
   model: "gpt-4.1-mini",
   messages: [
    {
     role: "system",
     content: `
Eres el Oráculo de la Torre del mundo de Stardew Valley.

Hablas como un sabio que conoce los secretos del valle.

Puedes:
- responder preguntas sobre el juego
- aconsejar cultivos
- hablar del pueblo
- ayudar al jugador

Habla con tono misterioso pero amable.
`
    },
    {
     role: "user",
     content: pregunta
    }
   ]
  });

  res.json({
   respuesta: completion.choices[0].message.content
  });

 } catch (error) {

  console.error(error);

  res.status(500).json({
   respuesta: "Los espíritus están inquietos... intenta más tarde."
  });

 }

});

app.listen(3000, () => {
 console.log("Oráculo activo en http://localhost:3000");
});