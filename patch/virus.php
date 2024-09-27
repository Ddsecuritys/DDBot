<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Email settings (replace with your email configurations)
define('ADMIN_EMAIL', 'admin@example.com');

// Initialize response message and scan results
$responseMessage = "";
$scanResults = [];

// Initialize scan history
if (!isset($_SESSION['scan_history'])) {
    $_SESSION['scan_history'] = [];
}

// Function to send email notifications
function sendEmailNotification($message) {
    $subject = "Malicious File Detected!";
    mail(ADMIN_EMAIL, $subject, $message);
}

// Function to log scan results
function logScanResults($results) {
    $logFile = 'scan_log.txt';
    $logEntry = date('Y-m-d H:i:s') . " - " . implode("\n", $results) . "\n\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

// Function to quarantine files
function quarantineFile($filePath) {
    $quarantineDir = 'quarantine/';
    if (!file_exists($quarantineDir)) {
        mkdir($quarantineDir, 0777, true);
    }
    $fileName = basename($filePath);
    $quarantinePath = $quarantineDir . $fileName;

    // Backup before quarantining
    copy($filePath, 'backup/' . $fileName);
    rename($filePath, $quarantinePath);
    return $quarantinePath;
}

// Function to scan a directory
function scanDirectory($dir) {
    $results = [];
    $patterns = [
        '/eval\(/',
        '/base64_decode\(/',
        '/shell_exec\(/'
    ];

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($files as $file) {
        if ($file->isFile() && $file->isReadable() && $file->getSize() < 1000000) { // Limit to 1MB
            $content = @file_get_contents($file->getPathname());
            if ($content === false) {
                $results[] = "Cannot read file: " . htmlspecialchars($file->getPathname());
                continue;
            }
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $content)) {
                    $results[] = "Malicious pattern found in file: " . htmlspecialchars($file->getPathname());
                    $quarantinePath = quarantineFile($file->getPathname());
                    $results[] = "File quarantined: " . htmlspecialchars($quarantinePath);
                    sendEmailNotification("Malicious pattern found in file: " . htmlspecialchars($file->getPathname()));
                    break;
                }
            }
        }
    }
    return $results;
}

// Handle form submission for scanning
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['scan_dir'])) {
    $directory = trim($_POST['scan_dir']);

    if (is_dir($directory)) {
        $scanResults = scanDirectory($directory);
        logScanResults($scanResults); // Log scan results
        $_SESSION['scan_history'][] = [
            'directory' => $directory,
            'results' => $scanResults,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        $responseMessage = "Scan completed.";
    } else {
        $responseMessage = "Invalid directory.";
    }
}

// Render HTML
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="/img/icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Virus Scanner</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000; /* Black background */
            color: #fff; /* White text */
        }
        .response {
            margin-top: 20px;
            background: #222; /* Dark background for response boxes */
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .input-group input {
            background-color: #333; /* Darker input background */
            color: #ffffff; /* White input text */
        }
        .input-group input::placeholder {
            color: #bbb; /* Light grey placeholder */
        }
        .btn-danger {
            background-color: #dc3545; /* Red button */
        }
        .navbar {
            background-color: #343a40; /* Dark navbar */
        }
        /* Help Modal Styles */
        .modal-content {
            background-color: #444; /* Dark grey for modal background */
            color: #fff; /* White text in modal */
        }
        .modal-header {
            border-bottom: 1px solid #555; /* Lighter grey border */
        }
        .button-container {
            text-align: left; /* Align buttons to the left */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Simple Virus Scanner</a>
</nav>

<div class="container mt-4">
    <h1 class="text-center">Virus Scanner</h1>

    <form method="POST">
        <div class="input-group mb-3">
            <input type="text" name="scan_dir" class="form-control" placeholder="Enter directory to scan" required>
            <div class="input-group-append">
                <button class="btn btn-danger" type="submit">Scan</button>
            </div>
        </div>
        <div class="button-container mb-3">
            <a href="/index.php" class="btn btn-secondary">Go Back</a>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#helpModal">Help</button>
        </div>
    </form>

    <div class="response">
        <h3>Scan Response:</h3>
        <p><?php echo $responseMessage; ?></p>
        <ul>
            <?php foreach ($scanResults as $result): ?>
                <li><?php echo $result; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="response">
        <h3>Scan History:</h3>
        <ul>
            <?php foreach ($_SESSION['scan_history'] as $history): ?>
                <li>
                    <strong><?php echo htmlspecialchars($history['directory']); ?></strong> -
                    <em><?php echo $history['timestamp']; ?></em>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="helpModalLabel">Help - Virus Scanner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Instructions:</h6>
                <p>1. Enter the full path of the directory you want to scan for malicious files.</p>
                <p>2. Click the "Scan" button to start the scanning process.</p>
                <p>3. The results will show any detected malicious patterns, and files will be quarantined if found.</p>
                <p>4. You can view the scan history for previously scanned directories.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
