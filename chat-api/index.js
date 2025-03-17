const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const DeepSeek = require('deepseek');

const app = express();
app.use(cors());
app.use(bodyParser.json());

const deepseek = new DeepSeek({
  baseURL: 'https://api.deepseek.com',
  apiKey: 'TU_API_KEY' // Reemplazar con tu API key real
});

// Chat médico especializado
app.post('/chat', async (req, res) => {
  try {
    const completion = await deepseek.chat.completions.create({
      messages: [
        {
          role: "system",
          content: "Eres un asistente médico especializado del Hospital Alt. Proporciona respuestas precisas y profesionales."
        },
        { role: "user", content: req.body.message }
      ],
      model: "deepseek-chat",
    });

    res.json({ response: completion.choices[0].message.content });
  } catch (error) {
    console.error('Error en la API de DeepSeek:', error);
    res.status(500).json({ error: 'Error en el servidor de IA' });
  }
});

const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Servidor de chat corriendo en http://localhost:${PORT}`);
});