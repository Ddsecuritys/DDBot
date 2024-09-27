<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize response message
$responseMessage = "";

$helpText = "
<h3>Available Commands:</h3>
<input type='text' id='searchInput' placeholder='Search commands...'>
<button onclick='filterCommands()'>Search</button>
<ul id='commandList'>
    <li><strong>open cmd</strong> - Opens Command Prompt.</li>
    <li><strong>open ipconfig</strong> - Opens Command Prompt Network.</li>
    <li><strong>open ping</strong> - Opens Command Prompt Ping Localhost.</li>
    <li><strong>open tracert</strong> - Opens Command Prompt Tracert Localhost.</li>
    <li><strong>open netsh wlan profiles</strong> - Opens Command Prompt Netsh Wlan Profiles.</li>
    <li><strong>open netsh wlan ssid</strong> - Opens Command Prompt Netsh Wlan SSID.</li>
    <li><strong>open systeminfo</strong> - Opens Command Prompt System Info.</li>
    <li><strong>open dir</strong> - Opens Command Prompt Folder.</li>
    <li><strong>open attrib</strong> - Displays or changes file attributes.</li>
    <li><strong>open fc</strong> - Compares two files and displays the differences.</li>
    <li><strong>open find</strong> - Searches for a text string in a file or files.</li>
    <li><strong>open more</strong> - Displays output one screen at a time.</li>
    <li><strong>open tree</strong> - Displays a graphical representation of the folder structure.</li>
    <li><strong>open arp</strong> - Displays the ARP table.</li>
    <li><strong>open net use</strong> - Displays or connects to shared resources.</li>
    <li><strong>open bcdedit</strong> - Displays or modifies boot configuration data.</li>
    <li><strong>open sfc</strong> - Scans and repairs system files.</li>
    <li><strong>open setx</strong> - Opens Command Prompt Setx.</li>
    <li><strong>open type</strong> - Opens Command Prompt Type.</li>
    <li><strong>open winver</strong> - Displays the Windows version information.</li>
    <li><strong>open powercfg</strong> - Opens Command Prompt Powercfg.</li>
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




// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['command'])) {
    $command = trim(strtolower($_POST['command']));


    // Check for ping or tracert commands with an address
    if (preg_match('/^(ping|tracert) (.+)$/', $command, $matches)) {
        $action = $matches[1];
        $address = escapeshellarg($matches[2]);
        $command = "$action $address";
    }

    // Define commands
    switch ($command) {
        case 'open cmd':
            shell_exec('start cmd');
            $responseMessage = "Command Prompt opened.";
            break;
        case 'open ipconfig':
            // Open Command Prompt and run ipconfig
            shell_exec('start cmd /k ipconfig');
            $responseMessage = "Command Prompt opened and 'ipconfig' executed.";
            break;
        case 'open ping':
            // Open Command Prompt and run ping with a default address
            shell_exec('start cmd /k "ping digitalcitizen.life"'); // Change 'localhost' to any default address you prefer
            $responseMessage = "Command Prompt opened and 'ping digitalcitizen.life' executed.";
            break;
        case 'open tracert':
            // Open Command Prompt and run tracert with a default address
            shell_exec('start cmd /k "tracert digitalcitizen.life"'); // Change 'localhost' to any default address you prefer
            $responseMessage = "Command Prompt opened and 'tracert digitalcitizen.life' executed.";
            break;
        case 'open netsh wlan profiles':
            // Open Command Prompt and run netsh wlan show profiles
            shell_exec('start cmd /k "netsh wlan show profiles"');
            $responseMessage = "Command Prompt opened and 'netsh wlan show profiles' executed.";
            break;
        case 'open netsh wlan ssid':
            // Open Command Prompt and run netsh wlan show profile for the specified SSID
            shell_exec("start cmd /k \"netsh wlan show profile name=$ssid key=clear\"");
            $responseMessage = "Command Prompt opened and 'netsh wlan show profile name=$ssid key=clear' executed.";
            break;
        case 'open systeminfo':
            // Open Command Prompt and run systeminfo
            shell_exec('start cmd /k systeminfo');
            $responseMessage = "Command Prompt opened and 'systeminfo' executed.";
            break;
        case 'open dir':
            // Open Command Prompt, navigate to the main directory, and run dir
            shell_exec('start cmd /k "cd C:\\ && dir"');
            $responseMessage = "Command Prompt opened, navigated to the main directory, and 'dir' executed.";
            break;
            //--
        case 'open attrib':
            shell_exec('start cmd /k "attrib /?"');
            $responseMessage = "Command Prompt opened and 'attrib /?' executed.";
            break;
        case 'open fc':
            shell_exec('start cmd /k "fc /?"');
            $responseMessage = "Command Prompt opened and 'fc /?' executed.";
            break;
        case 'open find':
            shell_exec('start cmd /k "find /?"');
            $responseMessage = "Command Prompt opened and 'find /?' executed.";
            break;
        case 'open more':
            shell_exec('start cmd /k "more /?"');
            $responseMessage = "Command Prompt opened and 'more /?' executed.";
            break;
        case 'open tree':
            shell_exec('start cmd /k "tree /?"');
            $responseMessage = "Command Prompt opened and 'tree /?' executed.";
            break;
        case 'open arp':
            shell_exec('start cmd /k "arp -a"');
            $responseMessage = "Command Prompt opened and 'arp -a' executed.";
            break;
        case 'open net use':
            shell_exec('start cmd /k "net use"');
            $responseMessage = "Command Prompt opened and 'net use' executed.";
            break;
        case 'open bcdedit':
            shell_exec('start cmd /k "bcdedit"');
            $responseMessage = "Command Prompt opened and 'bcdedit' executed.";
            break;
        case 'open sfc':
            // Path to the batch file
            $batchFile = '../net/run_sfc.bat'; // Ensure this path exists
            // Create the batch file content
            $batchContent = "@echo off\n";
            $batchContent .= "sfc /scannow\n";
            $batchContent .= "pause\n"; // Pause to see the results
            // Create the batch file
            file_put_contents($batchFile, $batchContent);
            // Run the batch file as administrator
            shell_exec("start cmd.exe /c runas /user:Administrator \"$batchFile\"");
            $responseMessage = "Command Prompt opened. Please enter the Administrator password to run 'sfc /scannow'.";
            break;
        case 'open setx':
            shell_exec('start cmd /k "setx /?"');
            $responseMessage = "Command Prompt opened and 'setx /?' executed.";
            break;
        case 'open type':
            shell_exec('start cmd /k "type nul"');
            $responseMessage = "Command Prompt opened and 'type nul' executed.";
            break;
        case 'open winver':
            shell_exec('start cmd /k "winver"');
            $responseMessage = "Command Prompt opened and 'winver' executed.";
            break;
        case 'open powercfg':
            shell_exec('start cmd /k "powercfg /?"');
            $responseMessage = "Command Prompt opened and 'powercfg /?' executed.";
            break;
        case 'open powercfg /energy':
            shell_exec('start cmd /k "powercfg /energy"');
            $responseMessage = "Command Prompt opened and 'powercfg /energy' executed.";
            break;
        case 'go back':
            $fileManagerPath = '/index.php'; // File is in the same directory
            header("Location: $fileManagerPath");
            exit; // Stop further execution after the redirect

        case 'help':
            $responseMessage = $helpText;
            break;
        default:
            $responseMessage = "Unknown command. Type 'help' for a list of available commands.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="/img/icon.png">
    <meta charset="UTF-8">
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
    <a class="navbar-brand" href="#">CMD Control Panel V 1.0</a>
</nav>

<div class="container mt-4">
    <h1 class="text-center">CMD Control Panel</h1>

    <div id="assistant">
        <h2 class="mt-4">Enter Command</h2>
        <form method="POST">
            <div class="input-group mb-3">
                <input type="text" name="command" class="form-control" placeholder="Enter command" required>
                <div class="input-group-append">
                    <button class="btn btn-danger" type="submit">Run</button>
                </div>
            </div>
        </form>

        <div class="response">
            <h3>Command Output:</h3>
            <?php echo $responseMessage; ?>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
