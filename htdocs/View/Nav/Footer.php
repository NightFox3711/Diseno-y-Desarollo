<head>
  <!-- Íconos de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/footer.css">
</head>

<style>
  .chatbot-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background-color: #1F3C6E;
    border: none;
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.2s ease, background-color 0.2s ease;
    z-index: 1000;
  }

  .chatbot-button i {
    font-size: 1.5rem;
    color: #ffffff;
  }

  .chatbot-button:hover {
    transform: scale(1.1);
    background-color: #16305a;
  }

  #chatboxContainer {
  display: none;
  position: fixed;
  bottom: 90px;
  right: 20px;
  width: 350px;
  height: 500px;
  background: white;
  border-radius: 12px;
  border: 2px solid #1f3c6e; /* Borde oscuro */
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4); /* Sombra más marcada */
  z-index: 1001;
  overflow: hidden;
}

</style>

<!-- Botón flotante del chatbot -->
<button id="chatbotBtn" class="chatbot-button" aria-label="Abrir chat">
  <i class="bi bi-chat-dots-fill"></i>
</button>

<!-- Contenedor flotante del chat -->
<div id="chatboxContainer">
  <iframe src="../../view/soporte/index.php" style="width: 100%; height: 100%; border: none;"></iframe>
</div>

<script>
  document.getElementById('chatbotBtn').addEventListener('click', function() {
    const box = document.getElementById('chatboxContainer');
    if (!box) return;
    box.style.display = (box.style.display === 'block') ? 'none' : 'block';
  });
</script>

<footer>
  <p>&copy; <?= date('Y'); ?> Solis Motors. Todos los derechos reservados.</p>
</footer>
