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
    <li><strong>open control panel</strong> - Opens the Control Panel.</li>
    <li><strong>open task manager</strong> - Opens Task Manager.</li>
    <li><strong>open file explorer</strong> - Opens File Explorer.</li>
    <li><strong>open calculator</strong> - Opens Calculator.</li>
    <li><strong>open sound settings</strong> - Opens Sound Settings.</li>
    <li><strong>open time settings</strong> - Opens Time Settings.</li>
    <li><strong>open my pc</strong> - Opens My PC.</li>
    <li><strong>open my pc properties</strong> - Opens My PC Properties.</li>
    <li><strong>open disk management</strong> - Opens My Disk Management.</li>
    <li><strong>open computer management</strong> - Opens My Computer Management.</li>
    <li><strong>open perfmon</strong> - Opens My Performance Monitor.</li>
    <li><strong>open resmon</strong> - Opens My Resource Monitor.</li>
    <li><strong>open my wifi</strong> - Opens Wi-Fi Settings.</li>
    <li><strong>open network connections</strong> - Opens Network Connections Settings.</li>
    <li><strong>open my firewall</strong> - Opens Firewall Settings.</li>
    <li><strong>open vpn settings</strong> - Opens VPN Settings.</li>
    <li><strong>open cmd</strong> - Opens Command Prompt.</li>
    <li><strong>open privacy and security</strong> - Opens Privacy and Security settings.</li>
    <li><strong>open settings</strong> - Opens Windows Settings.</li>
    <li><strong>open camera</strong> - Opens Camera.</li>
    <li><strong>get system info</strong> - Displays system information.</li>
    <li><strong>get disk usage</strong> - Displays disk usage information.</li>
    <li><strong>list processes</strong> - Lists all running processes.</li>
    <li><strong>system uptime</strong> - Displays the system uptime.</li>
    <li><strong>network config</strong> - Shows network configuration.</li>
    <li><strong>active connections</strong> - Lists all active internet connections.</li>
    <li><strong>list services</strong> - Shows the status of services.</li>
    <li><strong>list installed applications</strong> - Lists installed applications.</li>
    <li><strong>check memory</strong> - Displays memory usage.</li>
    <li><strong>cpu usage</strong> - Displays CPU usage percentage.</li>
    <li><strong>fetch current user</strong> - Displays the current user.</li>
    <li><strong>show disk space</strong> - Shows available disk space.</li>
    <li><strong>list usb devices</strong> - Lists connected USB devices.</li>
    <li><strong>check for windows updates</strong> - Checks for pending updates.</li>
    <li><strong>current user home</strong> - Displays the home directory of the current user.</li>
    <li><strong>show environment variables</strong> - Displays system environment variables.</li>
    <li><strong>check system time</strong> - Displays the current system date and time.</li>
    <li><strong>shutdown</strong> - The system is shutdown</li>
    <li><strong>restart</strong> - The system is restarting</li>
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
        case 'open control panel':
            shell_exec('start control panel');
            $responseMessage = "Control Panel opened.";
            break;
        case 'open task manager':
            shell_exec('start taskmgr');
            $responseMessage = "Task Manager opened.";
            break;
        case 'open file explorer':
            shell_exec('start explorer');
            $responseMessage = "File Explorer opened.";
            break;
        case 'open calculator':
            shell_exec('start calc');
            $responseMessage = "Calculator opened."; // Correct assignment operator
            break;
        case 'open sound settings':
            // Command to open the Sound settings
            shell_exec('start ms-settings:sound');
            $responseMessage = "Sound settings opened.";
            break;
        case 'open time settings':
            // Command to open Time settings
            shell_exec('start ms-settings:dateandtime');
            $responseMessage = "Time settings opened.";
            break;
        case 'open my pc':
            // Command to open "This PC"
            shell_exec('start explorer shell:MyComputerFolder');
            $responseMessage = "My PC opened.";
            break;
        case 'open my pc properties':
            // Command to open My Computer properties
            shell_exec('start control /name Microsoft.System');
            $responseMessage = "My Computer properties opened.";
            break;
        case 'open disk management':
            // Command to open Disk Management
            shell_exec('start diskmgmt.msc');
            $responseMessage = "Disk Management opened.";
            break;
        case 'open computer management':
            // Command to open Computer Management
            shell_exec('start compmgmt.msc');
            $responseMessage = "Computer Management opened.";
            break;
        case 'open perfmon':
            shell_exec('start perfmon');
            $responseMessage = "Performance Monitor opened.";
            break;
        case 'open resmon':
            shell_exec('start resmon');
            $responseMessage = "Resource Monitor opened.";
            break;
        case 'open my wifi':
            // Command to open Wi-Fi settings
            shell_exec('start ms-settings:network-wifi');
            $responseMessage = "Wi-Fi settings opened.";
            break;
        case 'open network connections':
            // Command to open Network Connections
            shell_exec('start ncpa.cpl');
            $responseMessage = "Network Connections opened.";
            break;
        case 'open my firewall':
            // Command to open Windows Firewall settings
            shell_exec('start control /name Microsoft.WindowsFirewall');
            $responseMessage = "Firewall settings opened.";
            break;
        case 'open vpn settings':
            // Command to open VPN settings
            shell_exec('start ms-settings:network-vpn');
            $responseMessage = "VPN settings opened.";
            break;
        case 'open cmd':
            shell_exec('start cmd');
            $responseMessage = "Command Prompt opened.";
            break;
        case 'open privacy and security':
            // Command to open Privacy settings
            shell_exec('start ms-settings:privacy');
            $responseMessage = "Privacy and Security settings opened.";
            break;
        case 'open settings':
            shell_exec('start ms-settings:');
            $responseMessage = "Settings opened.";
            break;
        case 'open camera':
            shell_exec('start microsoft.windows.camera:');
            $responseMessage = "Camera app opened.";
            break;
        case 'check for updates':
            // Command to open Windows Update settings
            shell_exec('start ms-settings:windows-update');
            $responseMessage = "Windows Update settings opened.";
            break;
        case 'get system info':
            $systemInfo = shell_exec('systeminfo');
            $responseMessage = "<pre style='color: lightgreen; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($systemInfo) . "</pre>";
            break;
        case 'get disk usage':
            $diskUsage = shell_exec('wmic logicaldisk get size,freespace,caption');
            $responseMessage = "<pre style='color: lightblue; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($diskUsage) . "</pre>";
            break;
        case 'list processes':
            $processes = shell_exec('tasklist');
            $responseMessage = "<pre style='color: lightyellow; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($processes) . "</pre>";
            break;
        case 'system uptime':
            // Execute the command to get system uptime
            $uptimeRaw = shell_exec('net statistics workstation | find "Statistics since"');

            if ($uptimeRaw) {
                // Extract the boot time from the output
                preg_match('/(\w+\s+\d+\s+\d+:\d+:\d+\s+\w+)/', $uptimeRaw, $matches);

                if (isset($matches[1])) {
                    // Convert the boot time to a DateTime object
                    $bootTime = DateTime::createFromFormat('D M d H:i:s Y', $matches[1]);
                    $currentDateTime = new DateTime();

                    // Calculate the difference (uptime)
                    $uptimeInterval = $currentDateTime->diff($bootTime);
                    $uptimeResponse = sprintf(
                        "System Uptime: %d days, %d hours, %d minutes, %d seconds",
                        $uptimeInterval->d,
                        $uptimeInterval->h,
                        $uptimeInterval->i,
                        $uptimeInterval->s
                    );

                    $responseMessage = "<pre style='color: lightcoral; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($uptimeResponse) . "</pre>";
                } else {
                    $responseMessage = "Could not parse the boot time.";
                }
            } else {
                $responseMessage = "Could not retrieve uptime information.";
            }
            break;
        case 'network config':
            $networkConfig = shell_exec('ipconfig');
            $responseMessage = "<pre style='color: lightcyan; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($networkConfig) . "</pre>";
            break;
        case 'active connections':
            $connections = shell_exec('netstat -an');
            $responseMessage = "<pre style='color: lightpink; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($connections) . "</pre>";
            break;
        case 'list services':
            $services = shell_exec('sc query state= all');
            $responseMessage = "<pre style='color: lightgreen; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($services) . "</pre>";
            break;
        case 'list installed applications':
            $apps = shell_exec('wmic product get name,version');
            $responseMessage = "<pre style='color: lightgray; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($apps) . "</pre>";
            break;
        case 'check memory':
            $memory = shell_exec('wmic OS get FreePhysicalMemory,TotalVisibleMemorySize');
            $responseMessage = "<pre style='color: lightgoldenrodyellow; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($memory) . "</pre>";
            break;
        case 'cpu usage':
            // Execute PowerShell command to get CPU usage
            $cpuUsage = shell_exec('powershell -Command "Get-Counter -Counter \'\Processor(_Total)\% Processor Time\' -SampleInterval 1 -MaxSamples 1 | Select-Object -ExpandProperty Countersamples | Select-Object -ExpandProperty CookedValue"');

            // Check if we received output
            if ($cpuUsage !== null) {
                $responseMessage = "<pre style='color: lightgreen; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>CPU Usage: " . htmlspecialchars(trim($cpuUsage)) . "%</pre>";
            } else {
                $responseMessage = "Unable to retrieve CPU usage.";
            }
            break;
        case 'fetch current user':
            $currentUser = shell_exec('whoami');
            $responseMessage = "<pre style='color: lightsalmon; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($currentUser) . "</pre>";
            break;
        case 'show disk space':
            // Get disk space information using PowerShell
            $diskSpace = shell_exec('powershell -command "Get-PSDrive -PSProvider FileSystem | Select-Object Name, @{Name=\'FreeSpace\';Expression={[math]::round($_.Free/1GB,2)}}, @{Name=\'UsedSpace\';Expression={[math]::round(($_.Used/1GB),2)}}, @{Name=\'TotalSpace\';Expression={[math]::round(($_.Used + $_.Free)/1GB,2)}}"');
            $responseMessage = "<pre style='color: lightcyan; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($diskSpace) . "</pre>";
            break;
        case 'list usb devices':
            // Get USB devices information using PowerShell
            $usbDevices = shell_exec('powershell -command "Get-PnpDevice -Class USB | Select-Object InstanceId, FriendlyName"');
            $responseMessage = "<pre style='color: lightgreen; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($usbDevices) . "</pre>";
            break;
        case 'check for windows updates':
            // Execute PowerShell command to check for updates using usoclient
            $updates = shell_exec('powershell -Command "Start-Process usoclient -ArgumentList \'StartScan\' -Verb RunAs"');
            $responseMessage = "Windows Update scan has been initiated.";
            break;
        case 'current user home':
            $homeDir = shell_exec('echo %USERPROFILE%');
            $responseMessage = "<pre style='color: lightgreen; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($homeDir) . "</pre>";
            break;
        case 'show environment variables':
            $envVars = shell_exec('set');
            $responseMessage = "<pre style='color: lightyellow; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($envVars) . "</pre>";
            break;
        case 'check system time':
            $systemTime = shell_exec('echo %date% %time%');
            $responseMessage = "<pre style='color: lightcyan; background-color: #2a2a4d; padding: 10px; border-radius: 5px;'>" . htmlspecialchars($systemTime) . "</pre>";
            break;
        case 'shutdown':
            shell_exec('shutdown /s /t 0');
            $responseMessage = "The system is shutting down...";
            break;
        case 'restart':
            shell_exec('shutdown /r /t 0');
            $responseMessage = "The system is restarting...";
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
    <a class="navbar-brand" href="#">Windows Control Panel V 1.0</a>
</nav>

<div class="container mt-4">
    <h1 class="text-center">Windows Control Panel</h1>

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
