<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'] ?? '';
    $comments = trim($_POST['comments'] ?? '');
} else {
    header("Location: encuestaSatisfaccion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Encuesta Recibida - MotorsBot</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <!-- Lo hizo Nicole -->
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
      text-align: center;
    }
    .message {
      margin: 30px auto;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>Encuesta Recibida</h1>
  </div>
  <div class="container">
    <div class="message">
      <h2>¡Gracias por tu participación!</h2>
      <p>Calificación: <?php echo htmlspecialchars($rating); ?></p>
      <?php if ($comments !== ''): ?>
        <p>Comentarios: <?php echo nl2br(htmlspecialchars($comments)); ?></p>
      <?php endif; ?>
      <a href="index.php" class="btn btn-primary">Volver al Chat</a>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
