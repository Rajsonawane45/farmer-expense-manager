
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'aami_shetkari';

// Function to test connection
function testConnection($host, $user, $pass) {
    try {
        $test_conn = new mysqli($host, $user, $pass);
        if ($test_conn->connect_error) {
            return false;
        }
        $test_conn->close();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// First try to connect to the specific database
try {
    $conn = new mysqli($host, $user, $pass, $db);
    
    // If database doesn't exist, create it
    if ($conn->connect_error) {
        // Check if we can connect to MySQL at all
        if (!testConnection($host, $user, $pass)) {
            die("
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; border: 2px solid #f44336; border-radius: 10px; background: #fff3f3;'>
                <h1 style='color: #f44336;'>🚨 MySQL Connection Failed!</h1>
                <p><strong>Error:</strong> Cannot connect to MySQL server</p>
                <h3>🔧 How to Fix:</h3>
                <ol>
                    <li><strong>Start XAMPP:</strong> Open XAMPP Control Panel</li>
                    <li><strong>Start MySQL:</strong> Click 'Start' button next to MySQL</li>
                    <li><strong>Wait for Green:</strong> MySQL should show green 'Running' status</li>
                    <li><strong>Refresh Page:</strong> Come back to this page</li>
                </ol>
                <h3>📋 Check These:</h3>
                <ul>
                    <li>Is XAMPP Control Panel open?</li>
                    <li>Is MySQL service started (green status)?</li>
                    <li>Are there any error messages in XAMPP?</li>
                    <li>Is port 3306 free (not used by other MySQL)?</li>
                </ul>
                <p style='background: #e8f5e8; padding: 10px; border-radius: 5px;'>
                    <strong>💡 Tip:</strong> Make sure you're running XAMPP as Administrator if you're on Windows
                </p>
            </div>
            ");
        }
        
        // Try to connect without database
        $temp_conn = new mysqli($host, $user, $pass);
        if ($temp_conn->connect_error) {
            die("Connection failed: " . $temp_conn->connect_error);
        }
        
        // Create database
        $sql = "CREATE DATABASE IF NOT EXISTS $db";
        if ($temp_conn->query($sql) === TRUE) {
            echo "<!-- Database '$db' created successfully -->";
        } else {
            die("Error creating database: " . $temp_conn->error);
        }
        
        $temp_conn->close();
        
        // Now connect to the created database
        $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }
} catch (Exception $e) {
    die("
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; border: 2px solid #f44336; border-radius: 10px; background: #fff3f3;'>
        <h1 style='color: #f44336;'>🚨 Database Error!</h1>
        <p><strong>Error:</strong> " . $e->getMessage() . "</p>
        <h3>🔧 Quick Fix:</h3>
        <ol>
            <li>Open XAMPP Control Panel</li>
            <li>Stop MySQL (if running)</li>
            <li>Start MySQL again</li>
            <li>Wait for green status</li>
            <li>Refresh this page</li>
        </ol>
    </div>
    ");
}

// Create tables if they don't exist
$conn->query("CREATE TABLE IF NOT EXISTS crops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    area VARCHAR(100),
    season VARCHAR(50),
    start_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crop_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (crop_id)
)");

$conn->query("CREATE TABLE IF NOT EXISTS incomes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crop_id INT NOT NULL,
    source VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (crop_id)
)");
?>