<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize response message
$responseMessage = "";

// Define available commands
$helpText = "
<h3>Available Commands:</h3>
<input type='text' id='searchInput' placeholder='Search commands...'>
<button onclick='filterCommands()'>Search</button>
<ul>
    <li><strong>open control panel</strong> - Opens System Preferences.</li>
    <li><strong>open task manager</strong> - Opens Activity Monitor.</li>
    <li><strong>open file explorer</strong> - Opens Finder.</li>
    <li><strong>open calculator</strong> - Opens Calculator.</li>
    <li><strong>open terminal</strong> - Opens Terminal.</li>
    <li><strong>open system preferences</strong> - Opens System Preferences.</li>
    <li><strong>open disk utility</strong> - Opens Disk Utility.</li>
    <li><strong>open activity monitor</strong> - Opens Activity Monitor.</li>
    <li><strong>open network preferences</strong> - Opens Network Preferences.</li>
    <li><strong>open sound preferences</strong> - Opens Sound Preferences.</li>
    <li><strong>open displays preferences</strong> - Opens Displays Preferences.</li>
    <li><strong>open user accounts</strong> - Opens User Accounts Preferences.</li>
    <li><strong>open battery preferences</strong> - Opens Battery Preferences.</li>
    <li><strong>open software update</strong> - Opens Software Update Preferences.</li>
    <li><strong>open security & privacy</strong> - Opens Security & Privacy settings.</li>
    <li><strong>open sharing preferences</strong> - Opens Sharing Preferences.</li>
    <li><strong>open printer & scanners</strong> - Opens Printer & Scanners settings.</li>
    <li><strong>open bluetooth preferences</strong> - Opens Bluetooth Preferences.</li>
    <li><strong>open energy saver</strong> - Opens Energy Saver Preferences.</li>
    <li><strong>open mission control</strong> - Opens Mission Control Preferences.</li>
    <li><strong>open keyboard preferences</strong> - Opens Keyboard Preferences.</li>
    <li><strong>open mouse preferences</strong> - Opens Mouse Preferences.</li>
    <li><strong>open trackpad preferences</strong> - Opens Trackpad Preferences.</li>
    <li><strong>open screenshots settings</strong> - Opens Screenshots Settings.</li>
    <li><strong>open iCloud settings</strong> - Opens iCloud Preferences.</li>
    <li><strong>open notes</strong> - Opens Notes.</li>
    <li><strong>open reminders</strong> - Opens Reminders.</li>
    <li><strong>open photos</strong> - Opens Photos.</li>
    <li><strong>open music</strong> - Opens Music.</li>
    <li><strong>open messages</strong> - Opens Messages.</li>
    <li><strong>open calendar</strong> - Opens Calendar.</li>
    <li><strong>open voice memos</strong> - Opens Voice Memos.</li>
    <li><strong>open facetime</strong> - Opens FaceTime.</li>
    <li><strong>open quicktime player</strong> - Opens QuickTime Player.</li>
    <li><strong>open time machine</strong> - Opens Time Machine.</li>
    <li><strong>open system information</strong> - Opens System Information.</li>
    <li><strong>open keychain access</strong> - Opens Keychain Access.</li>
    <li><strong>open accessibility settings</strong> - Opens Accessibility Settings.</li>
    <li><strong>open color calibration</strong> - Opens Color Calibration.</li>
    <li><strong>open safari</strong> - Opens Safari.</li>
    <li><strong>open mail</strong> - Opens Mail.</li>
    <li><strong>open pages</strong> - Opens Pages.</li>
    <li><strong>open numbers</strong> - Opens Numbers.</li>
    <li><strong>open keynote</strong> - Opens Keynote.</li>
    <li><strong>open adobe reader</strong> - Opens Adobe Reader.</li>
    <li><strong>open visual studio code</strong> - Opens Visual Studio Code.</li>
    <li><strong>open slack</strong> - Opens Slack.</li>
    <li><strong>open spotify</strong> - Opens Spotify.</li>
    <li><strong>open docker</strong> - Opens Docker.</li>
    <li><strong>open font book</strong> - Opens Font Book.</li>
    <li><strong>open system log</strong> - Opens Console (System Log).</li>
    <li><strong>open network utility</strong> - Opens Network Utility.</li>
    <li><strong>open character viewer</strong> - Opens Character Viewer.</li>
    <li><strong>open apple support</strong> - Opens Apple Support in default browser.</li>
    <li><strong>open app store</strong> - Opens App Store.</li>
    <li><strong>open contacts</strong> - Opens Contacts.</li>
    <li><strong>open chess</strong> - Opens Chess.</li>
    <li><strong>open preview</strong> - Opens Preview.</li>
    <li><strong>open dictionary</strong> - Opens Dictionary.</li>
    <li><strong>open voiceover utility</strong> - Opens VoiceOver Utility.</li>
    <li><strong>open digital color meter</strong> - Opens Digital Color Meter.</li>
    <li><strong>open screenshot utility</strong> - Opens Screenshot Utility.</li>
    <li><strong>go back</strong> - Goes Back.</li>
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

    // Command handling
    switch ($command) {
      case 'open terminal':
          shell_exec('open -a Terminal');
          $responseMessage = "Terminal opened.";
          break;
      case 'open system preferences':
          shell_exec('open /Applications/System\\ Preferences.app');
          $responseMessage = "System Preferences opened.";
          break;
      case 'open disk utility':
          shell_exec('open /Applications/Utilities/Disk\\ Utility.app');
          $responseMessage = "Disk Utility opened.";
          break;
      case 'open activity monitor':
          shell_exec('open /Applications/Utilities/Activity\\ Monitor.app');
          $responseMessage = "Activity Monitor opened.";
          break;
      case 'open network preferences':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.network"');
          $responseMessage = "Network Preferences opened.";
          break;
      case 'open sound preferences':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.sound"');
          $responseMessage = "Sound Preferences opened.";
          break;
      case 'open displays preferences':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.displays"');
          $responseMessage = "Displays Preferences opened.";
          break;
      case 'open user accounts':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.users"');
          $responseMessage = "User Accounts Preferences opened.";
          break;
      case 'open battery preferences':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.battery"');
          $responseMessage = "Battery Preferences opened.";
          break;
      case 'open software update':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.softwareupdate"');
          $responseMessage = "Software Update Preferences opened.";
          break;
      case 'open security & privacy':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.security"');
          $responseMessage = "Security & Privacy opened.";
          break;
      case 'open sharing preferences':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.sharing"');
          $responseMessage = "Sharing Preferences opened.";
          break;
      case 'open printer & scanners':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.printing"');
          $responseMessage = "Printer & Scanners opened.";
          break;
      case 'open bluetooth preferences':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.bluetooth"');
          $responseMessage = "Bluetooth Preferences opened.";
          break;
      case 'open energy saver':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.energy"');
          $responseMessage = "Energy Saver Preferences opened.";
          break;
      case 'open mission control':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.dock"');
          $responseMessage = "Mission Control Preferences opened.";
          break;
      case 'open keyboard preferences':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.keyboard"');
          $responseMessage = "Keyboard Preferences opened.";
          break;
      case 'open mouse preferences':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.mouse"');
          $responseMessage = "Mouse Preferences opened.";
          break;
      case 'open trackpad preferences':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.trackpad"');
          $responseMessage = "Trackpad Preferences opened.";
          break;
      case 'open screenshots settings':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.shortcut"');
          $responseMessage = "Screenshots Settings opened.";
          break;
      case 'open iCloud settings':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.icloud"');
          $responseMessage = "iCloud Preferences opened.";
          break;
      case 'open notes':
          shell_exec('open -a Notes');
          $responseMessage = "Notes opened.";
          break;
      case 'open reminders':
          shell_exec('open -a Reminders');
          $responseMessage = "Reminders opened.";
          break;
      case 'open photos':
          shell_exec('open -a Photos');
          $responseMessage = "Photos opened.";
          break;
      case 'open music':
          shell_exec('open -a Music');
          $responseMessage = "Music opened.";
          break;
      case 'open messages':
          shell_exec('open -a Messages');
          $responseMessage = "Messages opened.";
          break;
      case 'open calendar':
          shell_exec('open -a Calendar');
          $responseMessage = "Calendar opened.";
          break;
      case 'open voice memos':
          shell_exec('open -a "Voice Memos"');
          $responseMessage = "Voice Memos opened.";
          break;
      case 'open facetime':
          shell_exec('open -a FaceTime');
          $responseMessage = "FaceTime opened.";
          break;
      case 'open quicktime player':
          shell_exec('open -a "QuickTime Player"');
          $responseMessage = "QuickTime Player opened.";
          break;
      case 'open time machine':
          shell_exec('open /Applications/Utilities/Time\\ Machine.app');
          $responseMessage = "Time Machine opened.";
          break;
      case 'open system information':
          shell_exec('open /Applications/Utilities/System\\ Information.app');
          $responseMessage = "System Information opened.";
          break;
      case 'open keychain access':
          shell_exec('open /Applications/Utilities/Keychain\\ Access.app');
          $responseMessage = "Keychain Access opened.";
          break;
      case 'open accessibility settings':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.universalaccess"');
          $responseMessage = "Accessibility Settings opened.";
          break;
      case 'open color calibration':
          shell_exec('open "x-apple.systempreferences:com.apple.preference.displays#display"');
          $responseMessage = "Color Calibration opened.";
          break;
      case 'open safari':
          shell_exec('open -a Safari');
          $responseMessage = "Safari opened.";
          break;
      case 'open mail':
          shell_exec('open -a Mail');
          $responseMessage = "Mail opened.";
          break;
      case 'open messages':
          shell_exec('open -a Messages');
          $responseMessage = "Messages opened.";
          break;
      case 'open reminders':
          shell_exec('open -a Reminders');
          $responseMessage = "Reminders opened.";
          break;
      case 'open pages':
          shell_exec('open -a Pages');
          $responseMessage = "Pages opened.";
          break;
      case 'open numbers':
          shell_exec('open -a Numbers');
          $responseMessage = "Numbers opened.";
          break;
      case 'open keynote':
          shell_exec('open -a Keynote');
          $responseMessage = "Keynote opened.";
          break;
      case 'open adobe reader':
          shell_exec('open -a "Adobe Acrobat Reader"');
          $responseMessage = "Adobe Reader opened.";
          break;
      case 'open visual studio code':
          shell_exec('open -a "Visual Studio Code"');
          $responseMessage = "Visual Studio Code opened.";
          break;
      case 'open slack':
          shell_exec('open -a Slack');
          $responseMessage = "Slack opened.";
          break;
      case 'open spotify':
          shell_exec('open -a Spotify');
          $responseMessage = "Spotify opened.";
          break;
      case 'open docker':
          shell_exec('open -a Docker');
          $responseMessage = "Docker opened.";
          break;
      case 'open terminal':
          shell_exec('open -a Terminal');
          $responseMessage = "Terminal opened.";
          break;
      case 'open font book':
          shell_exec('open -a "Font Book"');
          $responseMessage = "Font Book opened.";
          break;
      case 'open system log':
          shell_exec('open /Applications/Utilities/Console.app');
          $responseMessage = "Console (System Log) opened.";
          break;
      case 'open network utility':
          shell_exec('open /Applications/Utilities/Network\\ Utility.app');
          $responseMessage = "Network Utility opened.";
          break;
      case 'open character viewer':
          shell_exec('open /Applications/Utilities/Character\\ Viewer.app');
          $responseMessage = "Character Viewer opened.";
          break;
      case 'open apple support':
          shell_exec('open "https://support.apple.com"');
          $responseMessage = "Apple Support opened in default browser.";
          break;
      case 'open app store':
          shell_exec('open /Applications/App\\ Store.app');
          $responseMessage = "App Store opened.";
          break;
      case 'open contacts':
          shell_exec('open -a Contacts');
          $responseMessage = "Contacts opened.";
          break;
      case 'open chess':
          shell_exec('open -a Chess');
          $responseMessage = "Chess opened.";
          break;
      case 'open preview':
          shell_exec('open -a Preview');
          $responseMessage = "Preview opened.";
          break;
      case 'open terminal':
          shell_exec('open -a Terminal');
          $responseMessage = "Terminal opened.";
          break;
      case 'open dictionary':
          shell_exec('open -a Dictionary');
          $responseMessage = "Dictionary opened.";
          break;
      case 'open voiceover utility':
          shell_exec('open /Applications/Utilities/VoiceOver\\ Utility.app');
          $responseMessage = "VoiceOver Utility opened.";
          break;
      case 'open digital color meter':
          shell_exec('open /Applications/Utilities/Digital\\ Color\\ Meter.app');
          $responseMessage = "Digital Color Meter opened.";
          break;
      case 'open screenshot utility':
          shell_exec('open /Applications/Utilities/Screenshot.app');
          $responseMessage = "Screenshot Utility opened.";
          break;
      case 'open system preferences':
          shell_exec('open /Applications/System\\ Preferences.app');
          $responseMessage = "System Preferences opened.";
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
    <a class="navbar-brand" href="/index.php">IOS Control Panel V 1.0</a>
</nav>

<div class="container mt-4">
    <h1 class="text-center">IOS Control Panel</h1>

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
