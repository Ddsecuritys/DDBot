<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/img/icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DD Send Message</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1e1e2f; color: #ffffff; }
        .response { margin-top: 20px; background: #2a2a4d; padding: 15px; border-radius: 5px; }
        .input-group input, .input-group select { background-color: #3a3a5f; color: #ffffff; }
        .btn-danger { background-color: #dc3545; }
        .navbar { background-color: #343a40; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">DD Send Message V 1.0</a>
</nav>

<div class="container mt-4">
    <h1 class="text-center">Send a Message</h1>

    <form action="mailto:ddsecurit-ys@hotmail.com" method="POST" enctype="text/plain">
        <div class="input-group mb-3">
            <input type="text" name="message" class="form-control" placeholder="Enter your message" required>
            <div class="input-group-append">
                <button class="btn btn-danger" type="submit">Send</button>
            </div>
        </div>
        <div class="form-group">
            <label for="options">Choose an option:</label>
            <select name="option" id="options" class="form-control" required>
                <option value="">Select an option</option>
                <option value="Window">Window Panel</option>
                <option value="IOS">IOS Panel</option>
                <option value="CMD">CMD Control</option>
                <option value="Terminal">Terminal Control</option>
                <option value="Virus">Virus Scaner</option>
            </select>
        </div>
        <a href="/index.php" class="btn btn-secondary">Go Back</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
