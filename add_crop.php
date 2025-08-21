<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Crop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #000000ff;
      color: #fff;
      font-family: 'Poppins', Arial, sans-serif;
      margin: 0;
      padding-bottom: 80px;
      /* for mobile nav */
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
      max-width: 420px;
      margin: 0 auto;
    }

    .card-form {
      background: #181818;
      border-radius: 16px;
      box-shadow: 0 2px 16px rgba(0, 0, 0, 0.25);
      padding: 28px 18px 18px 18px;
      margin-bottom: 18px;
    }

    .form-control {
      background-color: #ffffffff;
      color: #787070;
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

    .btn-primary {
      background: #4CAF50;
      border: none;
      border-radius: 8px;
      font-size: 1.1em;
      padding: 12px 0;
      width: 100%;
      margin-top: 6px;
      font-weight: 600;
    }

    .btn-primary:active,
    .btn-primary:focus {
      background: #388e3c;
    }

    h3 {
      font-size: 1.5em;
      font-weight: 700;
      margin-bottom: 18px;
      text-align: center;
      letter-spacing: 0.5px;
    }

    .alert {
      border-radius: 8px;
      font-size: 1em;
      margin-top: 10px;
    }

    @media (max-width: 600px) {
      .container {
        padding: 0 2vw;
      }

      .card-form {
        padding: 18px 6px 12px 6px;
      }

      h3 {
        font-size: 1.2em;
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
  <nav class="mobile-nav d-lg-none" style="background-color: black;">
    <a href="index.php"><span>🏠</span>Home</a>
    <a href="add_expense.php"><span>💸</span>Expenses</a>
    <a href="add_income.php"><span>📥</span>Income</a>
    <a href="report.php"><span>📊</span>Reports</a>
    <a href="profile.php"><span>📈</span>Profile</a>
  </nav>

  <div class="container py-4">
    <div class="card-form">
      <h3>➕ Add New Crop</h3>
      <form method="post" autocomplete="off">
        <input type="text" name="name" class="form-control" placeholder="Crop Name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
        <input type="text" name="area" class="form-control" placeholder="Area (acres/hectares)" value="<?= isset($_POST['area']) ? htmlspecialchars($_POST['area']) : '' ?>">
        <select name="season" class="form-control">
          <option value="">Select Season</option>
          <option value="Kharif" <?= (isset($_POST['season']) && $_POST['season'] == 'Kharif') ? 'selected' : '' ?>>Kharif</option>
          <option value="Rabi" <?= (isset($_POST['season']) && $_POST['season'] == 'Rabi') ? 'selected' : '' ?>>Rabi</option>
          <option value="Zaid" <?= (isset($_POST['season']) && $_POST['season'] == 'Zaid') ? 'selected' : '' ?>>Zaid</option>
        </select>
        <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="<?= isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-d') ?>">
        <button type="submit" name="save_crop" class="btn btn-primary mt-2">Save Crop</button>
      </form>
      <?php
      if (isset($_POST['save_crop'])) {
        $name = trim($_POST['name']);
        $area = trim($_POST['area']);
        $season = $_POST['season'];
        $start_date = $_POST['start_date'];
        
        if (!empty($name)) {
          $stmt = $conn->prepare("INSERT INTO crops (name, area, season, start_date) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $name, $area, $season, $start_date);
          
          if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center'>✅ Crop added successfully!</div>";
            // Clear form data after successful submission
            $_POST = array();
          } else {
            echo "<div class='alert alert-danger text-center'>❌ Error adding crop: " . $stmt->error . "</div>";
          }
          $stmt->close();
        } else {
          echo "<div class='alert alert-warning text-center'>⚠️ Please enter a crop name.</div>";
        }
      }
      ?>
    </div>
  </div>
</body>

</html>