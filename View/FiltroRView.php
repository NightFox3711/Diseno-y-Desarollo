<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motorcycle Search Results</title>
    <link rel="stylesheet" href="View/dist/css/style.css">
</head>

<body>
    <h2>Motorcycle Search Results</h2>
    <a href="../Views/FiltroBView.php">Go Back</a>
    <div class="results-container">
        <?php if (isset($motorcycles) && !empty($motorcycles)): ?>
            <?php foreach ($motorcycles as $motorcycle): ?>
                <div class="motorcycle-card">
                    <h3><?= htmlspecialchars($motorcycle['brand']) ?>         <?= htmlspecialchars($motorcycle['model']) ?></h3>
                    <p>Engine: <?= htmlspecialchars($motorcycle['engine_cc']) ?>cc</p>
                    <p>Price: $<?= htmlspecialchars($motorcycle['price']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No motorcycles found matching your criteria.</p>
        <?php endif; ?>

    </div>
</body>

</html>