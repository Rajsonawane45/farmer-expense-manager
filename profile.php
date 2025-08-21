<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - Aami Shetkari</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: #fff;
      font-family: 'Poppins', Arial, sans-serif;
      margin: 0;
      padding-bottom: 80px;
    }

    .mobile-nav {
      display: flex;
      justify-content: space-around;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background: #222;
      padding: 10px 0 6px 0;
      z-index: 1000;
      border-top: 1px solid #444;
    }

    .mobile-nav a {
      color: #fff;
      text-decoration: none;
      font-size: 13px;
      text-align: center;
      flex: 1;
      transition: color 0.2s;
    }

    .mobile-nav a span {
      font-size: 22px;
      display: block;
      margin-bottom: 2px;
    }

    .mobile-nav a.active,
    .mobile-nav a:active,
    .mobile-nav a:focus {
      color: #4CAF50;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .profile-card {
      background: #181818;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
      padding: 30px;
      margin: 30px auto;
      text-align: center;
    }

    .profile-avatar {
      width: 100px;
      height: 100px;
      background: #4CAF50;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3em;
      margin: 0 auto 20px;
    }

    .profile-name {
      font-size: 1.8em;
      font-weight: 700;
      margin-bottom: 10px;
      color: #4CAF50;
    }

    .profile-role {
      color: #bbb;
      font-size: 1.1em;
      margin-bottom: 30px;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 20px;
      margin: 30px 0;
    }

    .stat-item {
      background: #222;
      padding: 20px;
      border-radius: 12px;
      border-left: 4px solid #4CAF50;
    }

    .stat-number {
      font-size: 1.8em;
      font-weight: 700;
      color: #4CAF50;
      margin-bottom: 5px;
    }

    .stat-label {
      color: #bbb;
      font-size: 0.9em;
    }

    .recent-activity {
      background: #181818;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
      padding: 30px;
      margin: 20px auto;
    }

    .activity-item {
      background: #222;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 10px;
      border-left: 4px solid #4CAF50;
    }

    .activity-title {
      font-weight: 600;
      margin-bottom: 5px;
    }

    .activity-date {
      color: #bbb;
      font-size: 0.9em;
    }

    .btn-back {
      background: #4CAF50;
      border: none;
      border-radius: 8px;
      color: #fff;
      padding: 12px 24px;
      font-weight: 600;
      text-decoration: none;
      display: inline-block;
      margin-top: 20px;
      transition: background 0.3s ease;
    }

    .btn-back:hover {
      background: #388e3c;
      color: #fff;
      text-decoration: none;
    }

    @media (max-width: 768px) {
      .container {
        padding: 0 15px;
      }
      
      .profile-card,
      .recent-activity {
        padding: 20px;
      }
      
      .stats-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg sticky-top shadow custom-navbar-dark">
    <div class="container-fluid" style="background-color: black;">
      <a class="navbar-brand d-flex align-items-center text-white" href="#"
        style="font-size:1.5em;font-weight:700;letter-spacing:1px; align-items:center;">
        <span style="font-size:1.6em;margin-right:8px;">🌾</span>
        <span class="brand-gradient-text">Aami Shetkari</span>
      </a>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link nav-ani text-white" href="add_expense.php">Expenses</a></li>
          <li class="nav-item"><a class="nav-link nav-ani text-white" href="add_income.php">Income</a></li>
          <li class="nav-item"><a class="nav-link nav-ani text-white" href="report.php">Reports</a></li>
          <li class="nav-item"><a class="nav-link nav-ani text-white" href="profile.php">Profile</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Mobile Nav -->
  <nav class="mobile-nav d-lg-none">
    <a href="index.php"><span>🏠</span>Home</a>
    <a href="add_expense.php"><span>💸</span>Expenses</a>
    <a href="add_income.php"><span>📥</span>Income</a>
    <a href="report.php"><span>📊</span>Reports</a>
    <a href="profile.php" class="active"><span>👤</span>Profile</a>
  </nav>

  <div class="container">
    <!-- Profile Card -->
    <div class="profile-card">
      <div class="profile-avatar">👨‍🌾</div>
      <h2 class="profile-name">Farmer Profile</h2>
      <p class="profile-role">Agricultural Management System User</p>
      
      <!-- Statistics -->
      <div class="stats-grid">
        <?php
        // Get total crops
        $cropsResult = $conn->query("SELECT COUNT(*) as total FROM crops");
        $totalCrops = $cropsResult ? $cropsResult->fetch_assoc()['total'] : 0;
        
        // Get total expenses
        $expensesResult = $conn->query("SELECT SUM(amount) as total FROM expenses");
        $totalExpenses = $expensesResult ? $expensesResult->fetch_assoc()['total'] : 0;
        
        // Get total income
        $incomeResult = $conn->query("SELECT SUM(amount) as total FROM incomes");
        $totalIncome = $incomeResult ? $incomeResult->fetch_assoc()['total'] : 0;
        
        $totalProfit = $totalIncome - $totalExpenses;
        ?>
        <div class="stat-item">
          <div class="stat-number"><?= $totalCrops ?></div>
          <div class="stat-label">Total Crops</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">₹<?= number_format($totalExpenses) ?></div>
          <div class="stat-label">Total Expenses</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">₹<?= number_format($totalIncome) ?></div>
          <div class="stat-label">Total Income</div>
        </div>
        <div class="stat-item">
          <div class="stat-number <?= $totalProfit >= 0 ? 'text-success' : 'text-danger' ?>">₹<?= number_format($totalProfit) ?></div>
          <div class="stat-label">Net Profit/Loss</div>
        </div>
      </div>
      
      <a href="index.php" class="btn-back">← Back to Dashboard</a>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity">
      <h3 class="text-center mb-4">📈 Recent Activity</h3>
      
      <?php
      // Get recent crops
      $recentCrops = $conn->query("SELECT * FROM crops ORDER BY created_at DESC LIMIT 3");
      if ($recentCrops && $recentCrops->num_rows > 0) {
        echo "<h5 class='mb-3'>🌱 Recent Crops</h5>";
        while ($crop = $recentCrops->fetch_assoc()) {
          echo "<div class='activity-item'>";
          echo "<div class='activity-title'>{$crop['name']} ({$crop['season']})</div>";
          echo "<div class='activity-date'>Added on " . date('d M Y', strtotime($crop['created_at'])) . "</div>";
          echo "</div>";
        }
      }
      
      // Get recent expenses
      $recentExpenses = $conn->query("SELECT e.*, c.name as crop_name FROM expenses e JOIN crops c ON e.crop_id = c.id ORDER BY e.created_at DESC LIMIT 3");
      if ($recentExpenses && $recentExpenses->num_rows > 0) {
        echo "<h5 class='mb-3 mt-4'>💸 Recent Expenses</h5>";
        while ($expense = $recentExpenses->fetch_assoc()) {
          echo "<div class='activity-item'>";
          echo "<div class='activity-title'>₹{$expense['amount']} - {$expense['name']} ({$expense['crop_name']})</div>";
          echo "<div class='activity-date'>Added on " . date('d M Y', strtotime($expense['created_at'])) . "</div>";
          echo "</div>";
        }
      }
      
      // Get recent income
      $recentIncome = $conn->query("SELECT i.*, c.name as crop_name FROM incomes i JOIN crops c ON i.crop_id = c.id ORDER BY i.created_at DESC LIMIT 3");
      if ($recentIncome && $recentIncome->num_rows > 0) {
        echo "<h5 class='mb-3 mt-4'>📥 Recent Income</h5>";
        while ($income = $recentIncome->fetch_assoc()) {
          echo "<div class='activity-item'>";
          echo "<div class='activity-title'>₹{$income['amount']} - {$income['source']} ({$income['crop_name']})</div>";
          echo "<div class='activity-date'>Added on " . date('d M Y', strtotime($income['created_at'])) . "</div>";
          echo "</div>";
        }
      }
      ?>
    </div>
  </div>
</body>
</html>
