<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aami Shetkari - Farmer Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: #fff;
      font-family: 'Poppins', Arial, sans-serif;
      margin: 0;
      padding-bottom: 80px;
    }
    
    .hero-section {
      background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
      padding: 60px 20px;
      text-align: center;
      margin-bottom: 40px;
    }
    
    .hero-title {
      font-size: 2.5em;
      font-weight: 700;
      margin-bottom: 20px;
      color: #fff;
    }
    
    .hero-subtitle {
      font-size: 1.2em;
      color: #e8f5e8;
      margin-bottom: 30px;
    }
    
    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    .feature-card {
      background: #181818;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
      padding: 30px;
      margin-bottom: 30px;
      border: 1px solid #232323;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
    }
    
    .feature-icon {
      font-size: 3em;
      margin-bottom: 20px;
      display: block;
    }
    
    .feature-title {
      font-size: 1.5em;
      font-weight: 600;
      margin-bottom: 15px;
      color: #4CAF50;
    }
    
    .feature-description {
      color: #bbb;
      line-height: 1.6;
      margin-bottom: 20px;
    }
    
    .btn-feature {
      background: #4CAF50;
      border: none;
      border-radius: 8px;
      color: #fff;
      padding: 12px 24px;
      font-weight: 600;
      text-decoration: none;
      display: inline-block;
      transition: background 0.3s ease;
    }
    
    .btn-feature:hover {
      background: #388e3c;
      color: #fff;
      text-decoration: none;
    }
    
    .stats-section {
      background: #181818;
      border-radius: 16px;
      padding: 30px;
      margin-bottom: 30px;
      text-align: center;
    }
    
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }
    
    .stat-item {
      background: #222;
      padding: 20px;
      border-radius: 12px;
      border-left: 4px solid #4CAF50;
    }
    
    .stat-number {
      font-size: 2em;
      font-weight: 700;
      color: #4CAF50;
      margin-bottom: 5px;
    }
    
    .stat-label {
      color: #bbb;
      font-size: 0.9em;
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
    
    @media (max-width: 768px) {
      .hero-title {
        font-size: 2em;
      }
      
      .hero-subtitle {
        font-size: 1em;
      }
      
      .container {
        padding: 0 15px;
      }
      
      .feature-card {
        padding: 20px;
      }
      
      .stats-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <!-- Hero Section -->
  <div class="hero-section">
    <div class="container">
      <div class="hero-title">🌾 Aami Shetkari</div>
      <div class="hero-subtitle">Smart Farmer Management System</div>
      <p>Manage your crops, track expenses, monitor income, and analyze profits all in one place.</p>
    </div>
  </div>

  <div class="container">
    <!-- Statistics Section -->
    <div class="stats-section">
      <h3 class="text-center mb-4">📊 Quick Overview</h3>
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
    </div>

    <!-- Features Grid -->
    <div class="row">
      <div class="col-md-6">
        <div class="feature-card">
          <span class="feature-icon">🌱</span>
          <h3 class="feature-title">Manage Crops</h3>
          <p class="feature-description">Add new crops, track their growth stages, and manage crop-specific information like area, season, and start dates.</p>
          <a href="add_crop.php" class="btn-feature">Add New Crop</a>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="feature-card">
          <span class="feature-icon">💸</span>
          <h3 class="feature-title">Track Expenses</h3>
          <p class="feature-description">Record all your farming expenses including seeds, fertilizers, labor, equipment, and other costs associated with each crop.</p>
          <a href="add_expense.php" class="btn-feature">Add Expense</a>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="feature-card">
          <span class="feature-icon">📥</span>
          <h3 class="feature-title">Record Income</h3>
          <p class="feature-description">Track your income from crop sales, government subsidies, and other agricultural revenue sources.</p>
          <a href="add_income.php" class="btn-feature">Add Income</a>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="feature-card">
          <span class="feature-icon">📊</span>
          <h3 class="feature-title">View Reports</h3>
          <p class="feature-description">Generate comprehensive reports showing income, expenses, profit/loss analysis, and detailed breakdowns for each crop.</p>
          <a href="report.php" class="btn-feature">View Reports</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Navigation -->
  <nav class="mobile-nav d-lg-none">
    <a href="index.php" class="active"><span>🏠</span>Home</a>
    <a href="add_expense.php"><span>💸</span>Expenses</a>
    <a href="add_income.php"><span>📥</span>Income</a>
    <a href="report.php"><span>📊</span>Reports</a>
    <a href="profile.php"><span>👤</span>Profile</a>
  </nav>
</body>
</html>
