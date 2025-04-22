<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Encuesta de Satisfacción - MotorsBot</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #FFFFFF;
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
    }
    .header {
      background-color: #468EDB;
      color: #FFFFFF;
      padding: 20px;
      text-align: center;
    }
    .container {
      margin-top: 30px;
      max-width: 600px;
    }
    .survey-form label {
      margin-bottom: 5px;
      display: block;
    }
    .survey-form select, .survey-form textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
    }
    .survey-form button {
      padding: 10px 20px;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>Encuesta de Satisfacción</h1>
    <p>Tu opinión es muy importante para nosotros</p>
  </div>
  <div class="container">
    <form class="survey-form" method="POST" action="procesarEncuesta.php">
      <div>
        <label for="rating">Califica el servicio (1 - Malo, 5 - Excelente):</label>
        <select name="rating" id="rating" required>
          <option value="">Selecciona una opción</option>
          <option value="5">5 - Excelente</option>
          <option value="4">4 - Muy Bueno</option>
          <option value="3">3 - Bueno</option>
          <option value="2">2 - Regular</option>
          <option value="1">1 - Malo</option>
        </select>
      </div>
      <div>
        <label for="comments">Comentarios adicionales (opcional):</label>
        <textarea name="comments" id="comments" rows="4" placeholder="Tus comentarios..."></textarea>
      </div>
      <button type="submit" class="btn btn-primary w-100">Enviar Encuesta</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
