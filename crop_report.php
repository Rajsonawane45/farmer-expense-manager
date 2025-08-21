<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crop Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #ffffffff; color: #fff; }
    .card { background-color: #1f1f1f; border: 1px solid #333; }
  </style>
</head>
<body>
   <nav class="navbar navbar-expand-lg sticky-top shadow custom-navbar-dark">
  <div class="container-fluid" style="background-color: black;">
    <a class="navbar-brand d-flex align-items-center text-white" href="#" style="font-size:1.5em;font-weight:700;letter-spacing:1px; align-items:center;">
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
  <!-- Mobile Nav -->
<nav class="mobile-nav d-lg-none" style="background-color: black;">
  <a href="index.php"><span>🏠</span>Home</a>
  <a href="add_expense.php"><span>💸</span>Expenses</a>
  <a href="add_income.php"><span>📥</span>Income</a>
  <a href="report.php"><span>📊</span>Reports</a>
<a href="profile.php"><span>🧑‍🏫</span>Profile</a>
</nav>

<div class="container py-5">
  <h3 class="mb-4">📈 Crop Report</h3>
  <div class="row">
    <?php
      $res = $conn->query("SELECT * FROM crops");
      while ($c = $res->fetch_assoc()) {
        $cid = $c['id'];
        $exp = $conn->query("SELECT SUM(amount) as t FROM expenses WHERE crop_id=$cid")->fetch_assoc()['t'] ?? 0;
        $inc = $conn->query("SELECT SUM(amount) as t FROM incomes WHERE crop_id=$cid")->fetch_assoc()['t'] ?? 0;
        $profit = $inc - $exp;
    ?>
    <div class="col-md-4 mb-3">
      <div class="card p-3">
        <h5><?= $c['name'] ?></h5>
        <p>🧾 Expense: <span class="text-danger">₹ <?= $exp ?></span></p>
        <p>💰 Income: <span class="text-success">₹ <?= $inc ?></span></p>
        <p>📊 Profit/Loss: <strong class="<?= $profit >= 0 ? 'text-success' : 'text-danger' ?>">₹ <?= $profit ?></strong></p>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
</body>
</html>