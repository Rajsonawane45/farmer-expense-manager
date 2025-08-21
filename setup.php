<?php
// Setup file to create database and tables
$host = 'localhost';
$user = 'root';
$pass = '';

// First connect without database
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>🌾 Aami Shetkari - Database Setup</h1>";
echo "<p>Setting up your farmer management system...</p>";

// Create database if it doesn't exist
$db_name = 'aami_shetkari';
$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>✅ Database '$db_name' created successfully or already exists</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating database: " . $conn->error . "</p>";
}

// Select the database
$conn->select_db($db_name);

// Create tables
$tables = [
    'crops' => "CREATE TABLE IF NOT EXISTS crops (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        area VARCHAR(100),
        season VARCHAR(50),
        start_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    
    'expenses' => "CREATE TABLE IF NOT EXISTS expenses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        crop_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (crop_id)
    )",
    
    'incomes' => "CREATE TABLE IF NOT EXISTS incomes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        crop_id INT NOT NULL,
        source VARCHAR(255) NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (crop_id)
    )"
];

foreach ($tables as $table_name => $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ Table '$table_name' created successfully or already exists</p>";
    } else {
        echo "<p style='color: red;'>❌ Error creating table '$table_name': " . $conn->error . "</p>";
    }
}

// Add some sample data if tables are empty
$crops_count = $conn->query("SELECT COUNT(*) as count FROM crops")->fetch_assoc()['count'];
if ($crops_count == 0) {
    echo "<p>📝 Adding sample crop data...</p>";
    
    $sample_crops = [
        ['Wheat', '5', 'Rabi', '2024-11-01'],
        ['Soybean', '3', 'Kharif', '2024-06-15'],
        ['Cotton', '4', 'Kharif', '2024-05-20']
    ];
    
    $stmt = $conn->prepare("INSERT INTO crops (name, area, season, start_date) VALUES (?, ?, ?, ?)");
    foreach ($sample_crops as $crop) {
        $stmt->bind_param("ssss", $crop[0], $crop[1], $crop[2], $crop[3]);
        $stmt->execute();
    }
    $stmt->close();
    
    echo "<p style='color: green;'>✅ Added " . count($sample_crops) . " sample crops</p>";
}

echo "<h2>🎯 Setup Complete!</h2>";
echo "<p>Your farmer management system is now ready to use.</p>";

echo "<h2>🔗 Next Steps:</h2>";
echo "<p><a href='index.php'>🏠 Go to Home Dashboard</a></p>";
echo "<p><a href='test.php'>🧪 Run System Test</a></p>";
echo "<p><a href='add_crop.php'>🌱 Add New Crop</a></p>";
echo "<p><a href='add_expense.php'>💸 Add Expense</a></p>";
echo "<p><a href='add_income.php'>📥 Add Income</a></p>";
echo "<p><a href='report.php'>📊 View Reports</a></p>";

echo "<p style='color: blue; font-weight: bold;'>🚀 Your Aami Shetkari system is now running!</p>";
?>
