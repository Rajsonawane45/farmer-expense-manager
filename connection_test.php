<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySQL Connection Test - Aami Shetkari</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .status-box {
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            border-left: 5px solid;
        }
        .success {
            background: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
        .warning {
            background: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }
        .info {
            background: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #1e7e34;
        }
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background: #e0a800;
        }
        .step {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .step-number {
            background: #007bff;
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: inline-block;
            text-align: center;
            line-height: 25px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>🌾 Aami Shetkari - MySQL Connection Test</h1>
    
    <div class="info status-box">
        <h3>📋 What This Test Does:</h3>
        <p>This page will test if your MySQL database is running and accessible. This is the first step to get your farmer management system working.</p>
    </div>

    <?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    
    echo "<div class='step'>";
    echo "<h3><span class='step-number'>1</span>Testing Basic MySQL Connection...</h3>";
    
    try {
        $test_conn = new mysqli($host, $user, $pass);
        
        if ($test_conn->connect_error) {
            echo "<div class='error status-box'>";
            echo "<h4>❌ MySQL Connection Failed!</h4>";
            echo "<p><strong>Error:</strong> " . $test_conn->connect_error . "</p>";
            echo "<p><strong>Status:</strong> MySQL service is not running</p>";
            echo "</div>";
            
            echo "<div class='warning status-box'>";
            echo "<h4>🔧 How to Fix:</h4>";
            echo "<ol>";
            echo "<li><strong>Open XAMPP Control Panel</strong></li>";
            echo "<li><strong>Click 'Start' button next to MySQL</strong></li>";
            echo "<li><strong>Wait for green 'Running' status</strong></li>";
            echo "<li><strong>Refresh this page</strong></li>";
            echo "</ol>";
            echo "</div>";
            
            echo "<div class='info status-box'>";
            echo "<h4>📋 Common Issues:</h4>";
            echo "<ul>";
            echo "<li>XAMPP Control Panel not open</li>";
            echo "<li>MySQL service not started</li>";
            echo "<li>Port 3306 blocked by firewall</li>";
            echo "<li>Another MySQL service running</li>";
            echo "<li>XAMPP not running as Administrator</li>";
            echo "</ul>";
            echo "</div>";
            
            echo "<a href='connection_test.php' class='btn btn-warning'>🔄 Test Again</a>";
            echo "<a href='#' onclick='window.close()' class='btn'>❌ Close</a>";
            
        } else {
            echo "<div class='success status-box'>";
            echo "<h4>✅ MySQL Connection Successful!</h4>";
            echo "<p><strong>Status:</strong> MySQL service is running</p>";
            echo "<p><strong>Server:</strong> " . $test_conn->server_info . "</p>";
            echo "</div>";
            
            echo "<div class='step'>";
            echo "<h3><span class='step-number'>2</span>Testing Database Creation...</h3>";
            
            $db_name = 'aami_shetkari';
            $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
            
            if ($test_conn->query($sql) === TRUE) {
                echo "<div class='success status-box'>";
                echo "<h4>✅ Database Ready!</h4>";
                echo "<p>Database '$db_name' exists and is accessible</p>";
                echo "</div>";
                
                echo "<div class='info status-box'>";
                echo "<h4>🎯 Next Steps:</h4>";
                echo "<p>Your MySQL is working perfectly! Now you can:</p>";
                echo "<a href='setup.php' class='btn btn-success'>🚀 Run Full Setup</a>";
                echo "<a href='index.php' class='btn'>🏠 Go to Dashboard</a>";
                echo "<a href='test.php' class='btn'>🧪 Run System Test</a>";
                echo "</div>";
                
            } else {
                echo "<div class='error status-box'>";
                echo "<h4>❌ Database Creation Failed</h4>";
                echo "<p><strong>Error:</strong> " . $test_conn->error . "</p>";
                echo "</div>";
            }
            
            $test_conn->close();
        }
        
    } catch (Exception $e) {
        echo "<div class='error status-box'>";
        echo "<h4>❌ Connection Error!</h4>";
        echo "<p><strong>Exception:</strong> " . $e->getMessage() . "</p>";
        echo "</div>";
    }
    ?>
    
    <div class="step">
        <h3><span class='step-number'>3</span>XAMPP Status Check:</h3>
        <p><strong>Make sure in XAMPP Control Panel:</strong></p>
        <ul>
            <li>✅ <strong>MySQL</strong> shows green "Running" status</li>
            <li>✅ <strong>Apache</strong> shows green "Running" status</li>
            <li>❌ No red error messages</li>
            <li>❌ No port conflicts</li>
        </ul>
    </div>
    
    <div class="warning status-box">
        <h4>⚠️ Still Having Issues?</h4>
        <p>If MySQL still won't start:</p>
        <ol>
            <li>Close XAMPP completely</li>
            <li>Run XAMPP as Administrator (right-click → Run as Administrator)</li>
            <li>Start MySQL service again</li>
            <li>Check Windows Services for conflicting MySQL</li>
        </ol>
    </div>
    
    <div class="info status-box">
        <h4>📞 Need More Help?</h4>
        <p>Check the XAMPP error logs:</p>
        <ul>
            <li><strong>MySQL Log:</strong> XAMPP Control Panel → MySQL → Logs</li>
            <li><strong>Apache Log:</strong> XAMPP Control Panel → Apache → Logs</li>
        </ul>
    </div>
</body>
</html>
