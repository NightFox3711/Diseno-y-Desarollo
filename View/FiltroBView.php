<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Motorcycles</title>
    <link rel="stylesheet" href="../View/dist/css/style.css">
</head>
<body>
    <h2>Find Your Motorcycle</h2>
    <form action="../Controller/FiltroController.php" method="GET">
        
    <fieldset>
    <legend>Select Brand:</legend>
    <div>
        <label><input type="checkbox" name="brand[]" value="Yamaha"> Yamaha</label>
        <label><input type="checkbox" name="brand[]" value="Honda"> Honda</label>
        <label><input type="checkbox" name="brand[]" value="Suzuki"> Suzuki</label>
        <label><input type="checkbox" name="brand[]" value="Kawasaki"> Kawasaki</label>
    </div>
</fieldset>


        <label>Engine CC:</label>
        <select name="engine_cc">
            <option value="">Any</option>
            <option value="600">600cc</option>
            <option value="1000">1000cc</option>
        </select>

        <button type="submit" name="submit">Search</button>
    </form>
</body>
</html>
