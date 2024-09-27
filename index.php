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
    <li><strong>open window</strong> - Opens Windows Control Panel.</li>
    <li><strong>open ios</strong> - Opens IOS Control Panel.</li>
    <li><strong>open command prompt</strong> - Opens Command Prompt.</li>
    <li><strong>open terminal</strong> - Opens Terminal Command.</li>
    <li><strong>open virus scaner</strong> - Opens Virus Scaner Control Panel.</li>
    <li><strong>open our media</strong> - Opens Our Media Panel.</li>
    <li><strong>open report</strong> - Opens Report Prompt Panel.</li>
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
        case 'open window':
            $fileManagerPath = 'patch/file_manager.php'; // Adjust the path if necessary
            if (file_exists($fileManagerPath)) {
                // Redirect to the file manager
                header("Location: $fileManagerPath");
                exit;
            } else {
                $responseMessage = "File Manager does not exist.";
            }
            break;
        case 'open ios':
            $fileManagerPath = 'patch/ios.php'; // Adjust the path if necessary
            if (file_exists($fileManagerPath)) {
              error_log("Redirecting to: $fileManagerPath"); // Log for debugging
              header("Location: $fileManagerPath");
                exit;
              } else {
                $responseMessage = "File Manager does not exist.";
              }
            break;
        case 'open command prompt':
            $fileManagerPath = 'patch/command.php'; // Adjust the path if necessary
            if (file_exists($fileManagerPath)) {
                error_log("Redirecting to: $fileManagerPath"); // Log for debugging
                header("Location: $fileManagerPath");
                exit;
            } else {
                $responseMessage = "File Manager does not exist.";
            }
            break;
        case 'open terminal':
            $fileManagerPath = 'patch/terminal.php'; // Adjust the path if necessary
            if (file_exists($fileManagerPath)) {
                error_log("Redirecting to: $fileManagerPath"); // Log for debugging
                header("Location: $fileManagerPath");
                exit;
            } else {
                $responseMessage = "File Manager does not exist.";
            }
            break;
        case 'open virus scaner':
            $fileManagerPath = 'patch/virus.php'; // Adjust the path if necessary
            if (file_exists($fileManagerPath)) {
                error_log("Redirecting to: $fileManagerPath"); // Log for debugging
                header("Location: $fileManagerPath");
                exit;
            } else {
                $responseMessage = "File Manager does not exist.";
            }
                break;
        case 'open our media':
            $fileManagerPath = 'patch/media.php'; // Adjust the path if necessary
            if (file_exists($fileManagerPath)) {
                error_log("Redirecting to: $fileManagerPath"); // Log for debugging
                header("Location: $fileManagerPath");
                exit;
              } else {
                  $responseMessage = "File Manager does not exist.";
              }
                break;
            case 'open report':
            $fileManagerPath = 'patch/comments.php'; // Adjust the path if necessary
            if (file_exists($fileManagerPath)) {
                error_log("Redirecting to: $fileManagerPath"); // Log for debugging
                header("Location: $fileManagerPath");
                exit;
            } else {
                $responseMessage = "File Manager does not exist.";
            }
            break;
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
    <link rel="icon" href="img/icon.png">
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
    <a class="navbar-brand" href="index.php">DDBot Assistant V 1.0</a>
</nav>

<div class="container mt-4">
    <h1 class="text-center">Welcome to DDBot Assistant</h1>

    <div id="assistant">
        <h2 class="mt-4">Assistant Commands</h2>
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

<script>
    document.getElementById('getInfoBtn').addEventListener('click', () => {
        fetch('?action=getNetworkInfo')
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');
                if (data.error) {
                    resultDiv.innerText = data.error;
                } else {
                    resultDiv.innerHTML = `
                        <div class="info"><strong>Default Gateway:</strong> ${data.gateway}</div>
                        <div class="info"><strong>Local IP Address:</strong> ${data.local_ip}</div>
                        <div class="info"><strong>Subnet Mask:</strong> ${data.subnet_mask}</div>
                        <div class="info"><strong>Hostname:</strong> ${data.hostname}</div>
                    `;
                }
                resultDiv.style.display = 'block'; // Show the results
            })
            .catch(error => {
                const resultDiv = document.getElementById('result');
                resultDiv.innerText = 'Error fetching network information.';
                resultDiv.style.display = 'block'; // Show error
            });
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
