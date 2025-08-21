<?php
// Simple test file to check if everything is working
include 'db.php';

echo "<h1>🌾 Aami Shetkari - System Test</h1>";
echo "<p>Testing database connection and basic functionality...</p>";

// Test database connection
if ($conn->ping()) {
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
} else {
    echo "<p style='color: red;'>❌ Database connection failed!</p>";
    exit;
}

// Test if tables exist
$tables = ['crops', 'expenses', 'incomes'];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        echo "<p style='color: green;'>✅ Table '$table' exists</p>";
    } else {
        echo "<p style='color: red;'>❌ Table '$table' does not exist</p>";
    }
}

// Test basic queries
echo "<h2>📊 System Statistics:</h2>";

try {
    // Count crops
    $cropsResult = $conn->query("SELECT COUNT(*) as total FROM crops");
    if ($cropsResult) {
        $totalCrops = $cropsResult->fetch_assoc()['total'];
        echo "<p>🌱 Total Crops: $totalCrops</p>";
    }
    
    // Count expenses
    $expensesResult = $conn->query("SELECT COUNT(*) as total FROM expenses");
    if ($expensesResult) {
        $totalExpenses = $expensesResult->fetch_assoc()['total'];
        echo "<p>💸 Total Expenses: $totalExpenses</p>";
    }
    
    // Count incomes
    $incomeResult = $conn->query("SELECT COUNT(*) as total FROM incomes");
    if ($incomeResult) {
        $totalIncome = $incomeResult->fetch_assoc()['total'];
        echo "<p>📥 Total Incomes: $totalIncome</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>🔗 Navigation Links:</h2>";
echo "<p><a href='index.php'>🏠 Home Dashboard</a></p>";
echo "<p><a href='add_crop.php'>🌱 Add New Crop</a></p>";
echo "<p><a href='add_expense.php'>💸 Add Expense</a></p>";
echo "<p><a href='add_income.php'>📥 Add Income</a></p>";
echo "<p><a href='report.php'>📊 View Reports</a></p>";
echo "<p><a href='profile.php'>👤 Profile</a></p>";

echo "<h2>📝 Instructions:</h2>";
echo "<ol>";
echo "<li>First, add some crops using the 'Add New Crop' link</li>";
echo "<li>Then add expenses and income for those crops</li>";
echo "<li>View detailed reports to see your financial analysis</li>";
echo "</ol>";

echo "<p style='color: blue;'>🎯 If you see this page with green checkmarks, your system is working correctly!</p>";
?>
