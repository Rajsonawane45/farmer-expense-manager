<?php
// Registration logic placeholder (add DB logic as needed)
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm = $_POST['confirm'] ?? '';
  if ($name && $email && $password && $password === $confirm) {
    // TODO: Save to DB, hash password, check for existing user
    $msg = '<div class="alert alert-success text-center">Registration successful! (DB logic not implemented)</div>';
  } else {
    $msg = '<div class="alert alert-danger text-center">Please fill all fields and make sure passwords match.</div>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Farmer</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #121212;
      color: #fff;
      font-family: 'Poppins', Arial, sans-serif;
      margin: 0;
      padding-bottom: 80px;
    }
    .container { max-width: 420px; margin: 0 auto; }
    .card-form {
      background: #181818;
      border-radius: 16px;
      box-shadow: 0 2px 16px rgba(0,0,0,0.25);
      padding: 28px 18px 18px 18px;
      margin-top: 40px;
    }
    .form-control {
      background-color: #efefefff;
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
    .btn-primary {
      background: #4CAF50;
      border: none;
      border-radius: 8px;
      font-size: 1.1em;
      padding: 12px 0;
      width: 100%;
      font-weight: 600;
    }
    .btn-primary:active, .btn-primary:focus {
      background: #388e3c;
    }
    .switch-link {
      color: #4CAF50;
      text-decoration: underline;
      font-size: 0.98em;
      display: block;
      text-align: center;
      margin-top: 10px;
    }
    h3 { text-align: center; margin-bottom: 18px; }
    @media (max-width: 600px) {
      .container { padding: 0 2vw; }
      .card-form { padding: 18px 6px 12px 6px; }
      h3 { font-size: 1.2em; }
    }
  </style>
</head>
<body>
<div class="container">
  <div class="card-form">
    <h3>👨‍🌾 Farmer Registration</h3>
    <?= $msg ?>
    <form method="post" autocomplete="off">
      <input type="text" name="name" class="form-control" placeholder="Full Name" required>
      <input type="email" name="email" class="form-control" placeholder="Email" required>
      <input type="password" name="password" class="form-control" placeholder="Password" required>
      <input type="password" name="confirm" class="form-control" placeholder="Confirm Password" required>
      <button type="submit" class="btn btn-primary mt-2">Register</button>
    </form>
    <a href="login.php" class="switch-link">Already have an account? Login</a>
  </div>
</div>
</body>
</html>
