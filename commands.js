// Fetch public IP
function searchMyIP() {
    fetch('getPublicIP.php')
        .then(response => response.json())
        .then(data => {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = `<div class="info">${data.message}</div>`;
            resultDiv.style.display = 'block';
        });
}

// Fetch network information
function whatIsMyGateway() {
    fetch('?action=getNetworkInfo') // Connects to AJAX in index.php
        .then(response => response.json())
        .then(data => {
            const resultDiv = document.getElementById('result');
            if (data.error) {
                resultDiv.innerText = data.error;
            } else {
                resultDiv.innerHTML = `
                    <div class="info"><strong>Default Gateway:</strong> ${data.gateway}</div>
                `;
            }
            resultDiv.style.display = 'block';
        });
}

// Execute the command
document.getElementById('getInfoBtn').addEventListener('click', () => {
    const commandInput = document.querySelector('input[name="command"]');
    const command = commandInput.value.toLowerCase().trim();
    executeCommand(command); // Connects command input to functions
});
