<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financing Request</title>
    <link rel="stylesheet" href="View/dist/css/style.css">
</head>
<body>
    <h2>Financing Request</h2>
    <form action="../Controller/FinancingRequestController.php" method="POST">
        <div>
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" required>
        </div>
        <div>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>
        </div>
        <div>
            <label for="vehicle_interest">Vehicle of Interest:</label>
            <input type="text" id="vehicle_interest" name="vehicle_interest" required>
        </div>
        <div>
            <label for="requested_amount">Requested Amount:</label>
            <input type="number" id="requested_amount" name="requested_amount" step="0.01" required>
        </div>
        <div>
            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="Credit">Credit</option>
                <option value="Cash">Cash</option>
                <option value="Leasing">Leasing</option>
            </select>
        </div>
        <div>
            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments"></textarea>
        </div>
        <button type="submit">Submit Request</button>
    </form>
</body>
</html>
