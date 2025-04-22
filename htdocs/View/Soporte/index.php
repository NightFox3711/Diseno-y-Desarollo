<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>MotorsBot</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
    }

    .chatbox {
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    .header {
      background-color: #1F3C6E;
      color: white;
      padding: 10px 15px;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .header img {
      width: 32px;
      height: 32px;
      border-radius: 50%;
    }

    .body {
      flex: 1;
      padding: 10px;
      overflow-y: auto;
      background-color: white;
    }

    .body p {
      margin-bottom: 10px;
      font-size: 14px;
    }

    .bot {
      background-color: #f0f0f0;
      padding: 8px 12px;
      border-radius: 8px;
      margin-bottom: 6px;
      max-width: 85%;
    }

    .user {
      background-color: #1F3C6E;
      color: white;
      padding: 8px 12px;
      border-radius: 8px;
      margin-bottom: 6px;
      align-self: flex-end;
      max-width: 85%;
    }

    .chat-form {
      display: flex;
      border-top: 1px solid #ccc;
      padding: 10px;
      background-color: #fff;
    }

    .chat-form input[type="text"] {
      flex: 1;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 8px 12px;
      margin-right: 10px;
      font-size: 14px;
    }

    .chat-form input[type="submit"] {
      background-color: #1F3C6E;
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    .chat-form input[type="submit"]:hover {
      background-color: #16305a;
    }

    .footer-btns {
      text-align: center;
      margin-top: 10px;
    }

    .footer-btns button {
      background: none;
      border: none;
      color: #1F3C6E;
      font-size: 13px;
      cursor: pointer;
    }

    .footer-btns button:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="chatbox">
    <div class="header">
      <img src="img/perfil.jpg" alt="Bot Avatar">
      <strong>MotorsBot</strong>
    </div>

    <div class="body" id="chatbody">
      <div class="bot">¡Hola! soy MotorsBot, estoy para ayudarte a encontrar tu próximo carro 🚗.</div>
    </div>

    <form class="chat-form" id="chat-form" autocomplete="off">
      <input type="text" id="chat-input" placeholder="Pregúntame algo...">
      <input type="submit" value="Enviar">
    </form>

    <div class="footer-btns">
      <button onclick="window.location.href='encuestaSatisfaccion.php'">Finalizar Conversación</button> |
      <button onclick="mi_alerta()">Creadores</button>
    </div>
  </div>

  <script>
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatBody = document.getElementById('chatbody');

    chatForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const userMsg = chatInput.value.trim();
      if (!userMsg) return;

      // Mostrar mensaje del usuario
      const userBubble = document.createElement('div');
      userBubble.className = 'user';
      userBubble.textContent = userMsg;
      chatBody.appendChild(userBubble);

      // Limpiar input
      chatInput.value = '';

      // Scroll automático
      chatBody.scrollTop = chatBody.scrollHeight;

      // Obtener respuesta del bot
      fetch(`chat.php?msg=${encodeURIComponent(userMsg)}`)
        .then(res => res.text())
        .then(data => {
          const botBubble = document.createElement('div');
          botBubble.className = 'bot';
          botBubble.innerHTML = data;
          chatBody.appendChild(botBubble);
          chatBody.scrollTop = chatBody.scrollHeight;
        });
    });

    function mi_alerta() {
      alert("Desarrollado por Solis Motors IT Deparment");
    }
  </script>
</body>
</html>
