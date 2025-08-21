<?php
// report.php
include 'db.php'; // Connect to DB

// Fetch crops
$crops = $conn->query("SELECT * FROM crops");

// On crop select
$selectedCrop = isset($_GET['crop_id']) ? $_GET['crop_id'] : '';
$report = [];
$incomeDetails = [];
$expenseDetails = [];

if ($selectedCrop) {
  // Total income
  $incomeRes = $conn->query("SELECT SUM(amount) AS total_income FROM incomes WHERE crop_id = $selectedCrop");
  $income = $incomeRes->fetch_assoc()['total_income'] ?? 0;

  // Total expense
  $expenseRes = $conn->query("SELECT SUM(amount) AS total_expense FROM expenses WHERE crop_id = $selectedCrop");
  $expense = $expenseRes->fetch_assoc()['total_expense'] ?? 0;

  // Get detailed income entries
  $incomeDetailsRes = $conn->query("SELECT * FROM incomes WHERE crop_id = $selectedCrop ORDER BY date DESC");
  while ($row = $incomeDetailsRes->fetch_assoc()) {
    $incomeDetails[] = $row;
  }

  // Get detailed expense entries
  $expenseDetailsRes = $conn->query("SELECT * FROM expenses WHERE crop_id = $selectedCrop ORDER BY date DESC");
  while ($row = $expenseDetailsRes->fetch_assoc()) {
    $expenseDetails[] = $row;
  }

  $profit = $income - $expense;
  $report = [
    'income' => $income,
    'expense' => $expense,
    'profit' => $profit,
    'status' => $profit >= 0 ? 'Profit' : 'Loss'
  ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Crop Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background: #121212;
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
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      padding: 0 8px;
      box-sizing: border-box;
    }

    .card-form {
      background: #181818;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
      padding: 28px 18px 22px 18px;
      margin: 32px auto 24px auto;
      max-width: 420px;
      width: 100%;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .summary-card {
      background: #181818;
      border-radius: 16px;
      box-shadow: 0 2px 16px rgba(0, 0, 0, 0.25);
      padding: 22px 10px 16px 10px;
      margin-bottom: 18px;
      max-width: 420px;
      width: 100%;
      box-sizing: border-box;
      margin-left: auto;
      margin-right: auto;
    }

    .details-card {
      background: #181818;
      border-radius: 16px;
      box-shadow: 0 2px 16px rgba(0, 0, 0, 0.25);
      padding: 22px 10px 16px 10px;
      margin-bottom: 18px;
      max-width: 420px;
      width: 100%;
      box-sizing: border-box;
      margin-left: auto;
      margin-right: auto;
    }

    .form-select,
    .btn,
    .form-control {
      background-color: #fff;
      color: #787070;
      border: 1px solid #444;
      border-radius: 8px;
      font-size: 1.08em;
      padding: 13px 16px;
      margin-bottom: 14px;
      width: 100%;
      box-sizing: border-box;
    }

    .form-select:focus,
    .form-control:focus {
      border-color: #4CAF50;
      background: #232323;
      color: #fff;
      box-shadow: none;
    }

    .btn-dark,
    .btn-primary {
      background: #4CAF50;
      border: none;
      border-radius: 8px;
      font-size: 1.1em;
      padding: 12px 0;
      width: 100%;
      font-weight: 600;
    }

    .btn-dark:active,
    .btn-dark:focus,
    .btn-primary:active,
    .btn-primary:focus {
      background: #388e3c;
    }

    h2, h4 {
      font-size: 1.3em;
      font-weight: 700;
      margin-bottom: 18px;
      text-align: center;
      letter-spacing: 0.5px;
    }

    .report-box {
      padding: 14px 6px;
      background: #222;
      color: #fff;
      border-radius: 12px;
      margin-bottom: 10px;
      font-size: 1em;
    }

    .report-box.profit {
      background: #1b5e20;
      color: #b9ffb9;
    }

    .report-box.loss {
      background: #b71c1c;
      color: #ffd6d6;
    }

    .alert {
      border-radius: 8px;
      font-size: 1em;
      margin-top: 10px;
    }

    .entry-item {
      background: #222;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 8px;
      border-left: 4px solid #4CAF50;
    }

    .entry-item.expense {
      border-left-color: #f44336;
    }

    .entry-item.income {
      border-left-color: #4CAF50;
    }

    .entry-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 8px;
    }

    .entry-name {
      font-weight: 600;
      font-size: 1.1em;
    }

    .entry-amount {
      font-weight: 700;
      font-size: 1.2em;
    }

    .entry-amount.income {
      color: #4CAF50;
    }

    .entry-amount.expense {
      color: #f44336;
    }

    .entry-date {
      color: #bbb;
      font-size: 0.9em;
    }

    .section-title {
      color: #4CAF50;
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center;
    }

    /* Custom hover for Generate Report button */
    .btn-dark.mt-2:hover {
      background: #1976d2 !important;
      color: #fff !important;
    }

    @media (max-width: 600px) {
      .container {
        width: 100vw;
        max-width: 100vw;
        padding: 0 2vw;
        margin: 0;
        box-sizing: border-box;
      }
      .card-form {
        padding: 16px 2vw 12px 2vw;
        width: 98vw;
        max-width: 99vw;
        margin: 18px auto 18px auto;
        box-sizing: border-box;
      }
      .summary-card, .details-card {
        padding: 12px 2vw 10px 2vw;
        width: 98vw;
        max-width: 99vw;
        margin-left: auto;
        margin-right: auto;
        box-sizing: border-box;
      }
      .form-select,
      .btn,
      .form-control {
        font-size: 1em;
        padding: 12px 8px;
      }
      h2, h4 {
        font-size: 1.08em;
      }
      .report-box h3 {
        font-size: 1.1em;
      }
      .report-box h6 {
        font-size: 0.98em;
      }
      .row.mt-4>.col-12 {
        padding-left: 0;
        padding-right: 0;
      }
      canvas {
        max-width: 100% !important;
        height: auto !important;
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
          <li class="nav-item"><a class="nav-link nav-ani text-white" href="#">Profile</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <nav class="mobile-nav d-lg-none">
    <a href="index.php"><span>🏠</span>Home</a>
    <a href="add_expense.php"><span>💸</span>Expenses</a>
    <a href="add_income.php"><span>📥</span>Income</a>
    <a href="report.php"><span>📊</span>Reports</a>
    <a href="profile.php"><span>👤</span>Profile</a>
  </nav>

  <div class="container py-4">
   
    <div class="card-form">
       <h2>📊 Crop Income & Expense Report</h2>
      <form method="GET" autocomplete="off">
        <select name="crop_id" class="form-select" required>
          <option value="">Select Crop</option>
          <?php while ($row = $crops->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>" <?= $selectedCrop == $row['id'] ? 'selected' : '' ?>>
              <?= isset($row['crop_name']) ? $row['crop_name'] : (isset($row['name']) ? $row['name'] : 'Crop') ?>
              (<?= $row['season'] ?>) - <?= $row['area'] ?> acres
            </option>
          <?php endwhile; ?>
        </select>
        <button type="submit" class="btn btn-dark mt-2" style="color:#fff">Generate Report</button>
      </form>
    </div>

    <?php if (!empty($report)): ?>
      <div class="summary-card">
        <h4 class="mb-3 text-center">💡 Analysis for Selected Crop</h4>
        <div class="row text-center">
          <div class="col-12 mb-2">
            <div class="report-box">
              <h6>Total Income</h6>
              <h3>₹<?= number_format($report['income']) ?></h3>
            </div>
          </div>
          <div class="col-12 mb-2">
            <div class="report-box">
              <h6>Total Expense</h6>
              <h3>₹<?= number_format($report['expense']) ?></h3>
            </div>
          </div>
          <div class="col-12">
            <div class="report-box <?= $report['profit'] >= 0 ? 'profit' : 'loss' ?>">
              <h6><?= $report['status'] ?></h6>
              <h3>₹<?= number_format($report['profit']) ?></h3>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12 mb-3">
            <canvas id="barChart" height="120"></canvas>
          </div>
          <div class="col-12 mb-2">
            <canvas id="pieChart" height="120"></canvas>
          </div>
        </div>
        <div class="mt-3">
          <?php if ($report['profit'] >= 0): ?>
            <div class="alert alert-success text-center">✅ Great! You made a profit on this crop.</div>
          <?php else: ?>
            <div class="alert alert-danger text-center">⚠️ This crop resulted in a loss. Review your expenses carefully.
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Detailed Income Entries -->
      <?php if (!empty($incomeDetails)): ?>
      <div class="details-card">
        <h4 class="section-title">📥 Income Details</h4>
        <?php foreach ($incomeDetails as $income): ?>
        <div class="entry-item income">
          <div class="entry-header">
            <div class="entry-name"><?= htmlspecialchars($income['source']) ?></div>
            <div class="entry-amount income">₹<?= number_format($income['amount']) ?></div>
          </div>
          <div class="entry-date">📅 <?= date('d M Y', strtotime($income['date'])) ?></div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- Detailed Expense Entries -->
      <?php if (!empty($expenseDetails)): ?>
      <div class="details-card">
        <h4 class="section-title">💸 Expense Details</h4>
        <?php foreach ($expenseDetails as $expense): ?>
        <div class="entry-item expense">
          <div class="entry-header">
            <div class="entry-name"><?= htmlspecialchars($expense['name']) ?></div>
            <div class="entry-amount expense">₹<?= number_format($expense['amount']) ?></div>
          </div>
          <div class="entry-date">📅 <?= date('d M Y', strtotime($expense['date'])) ?></div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <script>
        // Chart.js Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
          type: 'bar',
          data: {
            labels: ['Income', 'Expense', 'Profit/Loss'],
            datasets: [{
              label: 'Amount (₹)',
              data: [<?= $report['income'] ?>, <?= $report['expense'] ?>, <?= $report['profit'] ?>],
              backgroundColor: [
                'rgba(76, 175, 80, 0.8)',
                'rgba(244, 67, 54, 0.8)',
                <?= $report['profit'] >= 0 ? "'rgba(76, 175, 80, 0.7)'" : "'rgba(244, 67, 54, 0.7)'" ?>
              ],
              borderRadius: 8,
              maxBarThickness: 40
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { display: false },
              title: { display: false }
            },
            scales: {
              y: { beginAtZero: true, ticks: { color: '#fff' }, grid: { color: '#333' } },
              x: { ticks: { color: '#fff' }, grid: { color: '#333' } }
            }
          }
        });
        
        // Chart.js Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
          type: 'pie',
          data: {
            labels: ['Income', 'Expense'],
            datasets: [{
              data: [<?= $report['income'] ?>, <?= $report['expense'] ?>],
              backgroundColor: [
                'rgba(76, 175, 80, 0.8)',
                'rgba(244, 67, 54, 0.8)'
              ],
              borderWidth: 0
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { labels: { color: '#fff', font: { size: 14 } } },
              title: { display: false }
            }
          }
        });
      </script>
    <?php endif; ?>
  </div>
</body>

</html>