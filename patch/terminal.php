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
    <li><strong>open terminal</strong> - Opens Terminal Command.</li>
    <li><strong>open local ip</strong> - Show Local IP Address: `ifconfig | grep inet`</li>
    <li><strong>open public ip</strong> - Show Public IP Address: `curl -s http://ipecho.net/plain`</li>
    <li><strong>open network info</strong> - Show Network Information: `ifconfig`</li>
    <li><strong>open dns servers</strong> - Show DNS Servers: `cat /etc/resolv.conf`</li>
    <li><strong>open gateway</strong> - Show Default Gateway: `netstat -rn | grep default`</li>
    <li><strong>open route table</strong> - Show Route Table: `netstat -rn`</li>
    <li><strong>open active connections</strong> - Show Active Connections: `lsof -i`</li>
    <li><strong>open ping test</strong> - Perform a Ping Test to google.com: `ping -c 4 google.com`</li>
    <li><strong>open traceroute</strong> - Perform a Traceroute to google.com: `traceroute google.com`</li>
    <li><strong>open firewall status</strong> - Check Firewall Status: `sudo /usr/libexec/ApplicationFirewall/socketfilterfw --getglobalstate`</li>
    <li><strong>open list interfaces</strong> - List all Network Interfaces: `networksetup -listallnetworkservices`</li>
    <li><strong>open current network</strong> - Show Current Network Information: `networksetup -getinfo Wi-Fi`</li>
    <li><strong>open mac address</strong> - Show MAC Address: `ifconfig en0 | grep ether`</li>
    <li><strong>open connection status</strong> - Test connection to 8.8.8.8: `ping -c 4 8.8.8.8`</li>
    <li><strong>open network services</strong> - List all network services: `scutil --list`</li>
    <li><strong>open reset network settings</strong> - Reset the network interface: `sudo ifconfig en0 down && sudo ifconfig en0 up`</li>
    <li><strong>open scan networks</strong> - Scan for available Wi-Fi networks: `airport -s`</li>
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
        case 'open terminal':
            shell_exec('open -a Terminal');
            $responseMessage = "Terminal opened.";
            break;
        case 'open local ip':
            shell_exec('open -a Terminal "ifconfig | grep inet"');
            $responseMessage = "Opened Terminal to show Local IP Address.";
            break;
        case 'open public ip':
            shell_exec('open -a Terminal "curl -s http://ipecho.net/plain"');
            $responseMessage = "Opened Terminal to show Public IP Address.";
            break;
        case 'open network info':
            shell_exec('open -a Terminal "ifconfig"');
            $responseMessage = "Opened Terminal to show Network Information.";
            break;
        case 'open dns servers':
            shell_exec('open -a Terminal "cat /etc/resolv.conf"');
            $responseMessage = "Opened Terminal to show DNS Servers.";
            break;
        case 'open gateway':
            shell_exec('open -a Terminal "netstat -rn | grep default"');
            $responseMessage = "Opened Terminal to show Default Gateway.";
            break;
        case 'open route table':
            shell_exec('open -a Terminal "netstat -rn"');
            $responseMessage = "Opened Terminal to show Route Table.";
            break;
        case 'open active connections':
            shell_exec('open -a Terminal "lsof -i"');
            $responseMessage = "Opened Terminal to show Active Connections.";
            break;
        case 'open ping test':
            shell_exec('open -a Terminal "ping -c 4 google.com"');
            $responseMessage = "Opened Terminal to perform a Ping Test to google.com.";
            break;
        case 'open traceroute':
            shell_exec('open -a Terminal "traceroute google.com"');
            $responseMessage = "Opened Terminal to perform a Traceroute to google.com.";
            break;
        case 'open firewall status':
            shell_exec('open -a Terminal "sudo /usr/libexec/ApplicationFirewall/socketfilterfw --getglobalstate"');
            $responseMessage = "Opened Terminal to check Firewall Status.";
            break;
        case 'open list interfaces':
            shell_exec('open -a Terminal "networksetup -listallnetworkservices"');
            $responseMessage = "Opened Terminal to list all Network Interfaces.";
            break;
        case 'open current network':
            shell_exec('open -a Terminal "networksetup -getinfo Wi-Fi"');
            $responseMessage = "Opened Terminal to show Current Network Information.";
            break;
        case 'open mac address':
            shell_exec('open -a Terminal "ifconfig en0 | grep ether"');
            $responseMessage = "Opened Terminal to show MAC Address.";
            break;
        case 'open connection status':
            shell_exec('open -a Terminal "ping -c 4 8.8.8.8"');
            $responseMessage = "Opened Terminal to test connection to Google's DNS (8.8.8.8).";
            break;
        case 'open network services':
            shell_exec('open -a Terminal "scutil --list"');
            $responseMessage = "Opened Terminal to list all network services.";
            break;
        case 'open reset network settings':
            shell_exec('open -a Terminal "sudo ifconfig en0 down && sudo ifconfig en0 up"');
            $responseMessage = "Opened Terminal to reset the network interface.";
            break;
        case 'open scan networks':
            shell_exec('open -a Terminal "airport -s"');
            $responseMessage = "Opened Terminal to scan for available Wi-Fi networks.";
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
    <a class="navbar-brand" href="index.html">Terminal Command V 1.0</a>
</nav>

<div class="container mt-4">
    <h1 class="text-center">Terminal Command Panel</h1>

    <div id="assistant">
        <h2 class="mt-4">Enter Command</h2>
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
