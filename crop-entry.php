<?php
// db.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'aami_shetkari';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
?>

<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crop Manager - Aami Shetkari</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: #fff;
      font-family: 'Poppins', Arial, sans-serif;
      margin: 0;
      padding-bottom: 80px;
    }
    .navbar {
      background-color: #181818 !important;
      color: #fff;
      border-bottom: 1px solid #222;
    }
    .container {
      max-width: 420px;
      margin: 0 auto;
    }
    .card {
      background: #181818;
      color: #fff;
      border-radius: 16px;
      box-shadow: 0 2px 16px rgba(0,0,0,0.25);
      border: 1px solid #232323;
    }
    .form-control {
      background-color: #232323;
      color: #fff;
      border: 1px solid #444;
      border-radius: 8px;
      font-size: 1.08em;
      padding: 12px 14px;
      margin-bottom: 14px;
    }
    .form-control:focus {
      border-color: #4CAF50;
      background: #232323;
      color: #fff;
      box-shadow: none;
    }
    .form-control::placeholder {
      color: #bbb;
    }
    .btn-primary {
      background: #4CAF50;
      border: none;
      border-radius: 8px;
      font-size: 1.1em;
      padding: 12px 0;
      width: 100%;
      font-weight: 600;
      color: #fff;
    }
    .btn-primary:active, .btn-primary:focus {
      background: #388e3c;
    }
    .btn-outline-light {
      border-color: #4CAF50;
      color: #4CAF50;
      border-radius: 8px;
      width: 100%;
      margin-bottom: 10px;
      background: transparent;
    }
    .btn-outline-light:hover {
      background: #4CAF50;
      color: #fff;
    }
    h2, h5 {
      color: #4CAF50;
      font-weight: 700;
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
    .mobile-nav a.active, .mobile-nav a:active, .mobile-nav a:focus {
      color: #4CAF50;
    }
    @media (max-width: 600px) {
      .container { padding: 0 2vw; }
      .card { padding: 18px 6px 12px 6px; }
      h2 { font-size: 1.2em; }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark px-3">
    <a class="navbar-brand" href="#">🌾 Aami Shetkari</a>
  </nav>
  <!-- Mobile Nav -->
<nav class="mobile-nav d-lg-none" style="background-color: black;">
  <a href="index.php"><span>🏠</span>Home</a>
  <a href="add_expense.php"><span>💸</span>Expenses</a>
  <a href="add_income.php"><span>📥</span>Income</a>
  <a href="report.php"><span>📊</span>Reports</a>
 <a href="profile.php"><span>📈</span>Profile</a>
</nav>


  <div class="container py-4">
    <h2 class="mb-4">Crop Management</h2>
    
    <!-- Crop Form -->
    <div class="card p-3 mb-4">
      <h5>➕ Add or Select Crop</h5>
      <form method="post" action="">
        <div class="row g-3">
          <div class="col-md-3">
            <input type="text" name="crop_name" class="form-control" placeholder="Crop Name">
          </div>
          <div class="col-md-2">
            <input type="text" name="area" class="form-control" placeholder="Area (acres/hectares)">
          </div>
          <div class="col-md-2">
            <select name="season" class="form-control">
              <option value="">Season</option>
              <option value="Kharif">Kharif</option>
              <option value="Rabi">Rabi</option>
              <option value="Zaid">Zaid</option>
            </select>
          </div>
          <div class="col-md-3">
            <input type="date" name="start_date" class="form-control">
          </div>
          <div class="col-md-2">
            <button type="submit" name="add_crop" class="btn btn-primary w-100">Save Crop</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Expense & Income Section -->
    <?php
      include 'db.php';

      if (isset($_POST['add_crop'])) {
        $name = $_POST['crop_name'];
        $area = $_POST['area'];
        $season = $_POST['season'];
        $date = $_POST['start_date'];
        if ($name != '') {
          $conn->query("INSERT INTO crops (name, area, season, start_date) VALUES ('$name', '$area', '$season', '$date')");
        }
      }

      $crop_result = $conn->query("SELECT * FROM crops ORDER BY id DESC");
      $selected_crop = $crop_result->fetch_assoc();
      if ($selected_crop):
        $cid = $selected_crop['id'];
    ?>
    <div class="card p-3 mb-4">
      <h5>🌱 Active Crop: <strong><?= $selected_crop['name'] ?></strong></h5>
      <!-- Expense -->
      <form method="post" class="mb-3">
        <input type="hidden" name="cid" value="<?= $cid ?>">
        <div class="row g-3">
          <div class="col-md-4">
            <input type="text" name="expense_name" class="form-control" placeholder="Expense Name">
          </div>
          <div class="col-md-3">
            <input type="number" name="expense_amt" class="form-control" placeholder="Amount">
          </div>
          <div class="col-md-3">
            <input type="date" name="expense_date" class="form-control">
          </div>
          <div class="col-md-2">
            <button type="submit" name="add_expense" class="btn btn-outline-light w-100">Add Expense</button>
          </div>
        </div>
      </form>
      
      <!-- Income -->
      <form method="post">
        <input type="hidden" name="cid" value="<?= $cid ?>">
        <div class="row g-3">
          <div class="col-md-4">
            <input type="text" name="income_name" class="form-control" placeholder="Income Source">
          </div>
          <div class="col-md-3">
            <input type="number" name="income_amt" class="form-control" placeholder="Amount">
          </div>
          <div class="col-md-3">
            <input type="date" name="income_date" class="form-control">
          </div>
          <div class="col-md-2">
            <button type="submit" name="add_income" class="btn btn-outline-light w-100">Add Income</button>
          </div>
        </div>
      </form>
    </div>

    <?php
      if (isset($_POST['add_expense'])) {
        $conn->query("INSERT INTO expenses (crop_id, name, amount, date) VALUES ({$_POST['cid']}, '{$_POST['expense_name']}', {$_POST['expense_amt']}, '{$_POST['expense_date']}')");
      }
      if (isset($_POST['add_income'])) {
        $conn->query("INSERT INTO incomes (crop_id, source, amount, date) VALUES ({$_POST['cid']}, '{$_POST['income_name']}', {$_POST['income_amt']}, '{$_POST['income_date']}')");
      }

      $total_exp = $conn->query("SELECT SUM(amount) as total FROM expenses WHERE crop_id = $cid")->fetch_assoc()['total'] ?? 0;
      $total_inc = $conn->query("SELECT SUM(amount) as total FROM incomes WHERE crop_id = $cid")->fetch_assoc()['total'] ?? 0;
    ?>

    <!-- Summary -->
    <div class="row">
      <div class="col-md-4">
        <div class="card p-3 mb-3">
          <h6>Total Expense:</h6>
          <h4 class="text-danger">₹ <?= $total_exp ?>
          </h4>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3 mb-3">
          <h6>Total Income:</h6>
          <h4 class="text-success">₹ <?= $total_inc ?>
          </h4>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3 mb-3">
          <h6>Profit/Loss:</h6>
          <h4 class="<?= ($total_inc - $total_exp >= 0) ? 'text-success' : 'text-danger' ?>">₹ <?= $total_inc - $total_exp ?>
          </h4>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</body>
</html>
