<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define available commands
$helpText = "
<h3>Available Commands:</h3>
<input type='text' id='searchInput' placeholder='Search commands...'>
<button onclick='filterCommands()'>Search</button>
<ul>
    <li><strong>open ddsecurity</strong> - Opens Our Website Page.</li>
    <li><strong>open Facebook</strong> - Opens Our Facebook Page.</li>
    <li><strong>open linkin</strong> - Opens Our Linkin Page.</li>
    <li><strong>open github</strong> - Opens Our Github Page.</li>
    <li><strong>go back</strong> - Goes back</li>
    <li><strong>help</strong> - Displays this help message.</li>
</ul>

<script>
function filterCommands() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const ul = document.getElementById('commandList');
    const li = ul.getElementsByTagName('li');

    for (let i = 0; i < li.length; i++) {
        const command = li[i].textContent || li[i].innerText;
        li[i].style.display = command.toLowerCase().includes(input) ? '' : 'none';
    }
}
</script>

";

// Initialize response message
$responseMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['command'])) {
    $command = strtolower(trim($_POST['command']));
    switch ($command) {
        case 'open ddsecurity':
            $websiteUrl = 'https://ddsecurity.netlify.app';
            shell_exec("start $websiteUrl");
            $responseMessage = "DD Security website is now opening in your default web browser.";
            break;
        case 'open facebook':
            $facebookUrl = 'https://www.facebook.com/DDAIT';
            shell_exec("start $facebookUrl");
            $responseMessage = "Facebook is now opening in your default web browser.";
            break;
        case 'open linkedin':
            $linkedinUrl = 'https://www.linkedin.com/company/ddsecurity';
            shell_exec("start $linkedinUrl");
            $responseMessage = "LinkedIn is now opening in your default web browser.";
            break;
        case 'open github':
            $githubUrl = 'https://github.com/Ddsecuritys';
            shell_exec("start $githubUrl");
            $responseMessage = "GitHub is now opening in your default web browser.";
            break;
        case 'go back':
            $fileManagerPath = '/index.php'; // File is in the same directory
            header("Location: $fileManagerPath");
            exit; // Stop further execution after the redirect
        case 'help':
            $responseMessage = $helpText;
            break;
        default:
            $responseMessage = "I'm sorry, I don't understand that command.";
    }
}

// Handle AJAX requests for network info
if (isset($_GET['action']) && $_GET['action'] === 'getNetworkInfo') {
    // You need to define GetAllNetworkInterfaces and GetGatewayInfo functions here
    $interfaces = GetAllNetworkInterfaces(); // Ensure this function is defined
    $gatewayInfo = GetGatewayInfo($interfaces); // Ensure this function is defined
    echo json_encode($gatewayInfo);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/img/icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DD Bot</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #1e1e2f;
        color: #fff;
    }
    .response {
        margin-top: 20px;
        background: #2a2a4d;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }
    #commandList {
        list-style-type: none;
        padding: 0;
    }
    #commandList li {
        padding: 5px 0;
    }
    .search-container {
    margin-bottom: 20px;
    }

    input[type='text'] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: calc(100% - 100px);
    margin-right: 10px;
    font-size: 16px;
    }

    button {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    background-color: #007BFF;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    }

    button:hover {
    background-color: #0056b3;
    }

    ul {
    list-style-type: none;
    padding: 0;
    }

    li {
    padding: 8px;
    border-bottom: 1px solid #ddd;
    }

    li strong {
    color: #28a745;
    }

    li:last-child {
    border-bottom: none;
    }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">DD Security Media</a>
</nav>

<div class="container mt-4">
    <h1 class="text-center">Welcome to DDSecurity</h1>

    <div id="assistant">
        <h2 class="mt-4">Media Accounts</h2>
        <form method="POST">
            <div class="input-group mb-3">
                <input type="text" name="command" class="form-control" placeholder="What can I do for you?" required>
                <div class="input-group-append">
                    <button class="btn btn-danger" type="submit">Send</button>
                </div>
            </div>
        </form>

        <div class="response">
            <h3>Response:</h3>
            <p><?php echo $responseMessage; ?></p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
