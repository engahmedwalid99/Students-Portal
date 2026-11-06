<?php
session_start();
include 'config.php';
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean($_POST['username'] ?? '');
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $role     = in_array($_POST['role'] ?? '', ['admin', 'student']) ? $_POST['role'] : 'student';

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $role]);
        $msg = "<div class='alert alert-success'>Registration successful! <a href='login.php'>Login here</a></div>";
    } catch (PDOException $e) {
        $msg = "<div class='alert alert-danger'>Username already exists!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - Student System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php'; ?>

<div class="container mb-5">
  <div class="row justify-content-center">
    <div class="col-lg-5 col-md-8">
      <div class="app-card">
        <div class="card-head bordered">
          <div class="icon-box"><i class="bi bi-person-plus-fill"></i></div>
          <div>
            <h4>Register</h4>
            <small>Create a new account</small>
          </div>
        </div>
        <div class="card-body-pad pt-4">
          <?= $msg ?>
          <form method="POST">
            <label class="form-label">Username</label>
            <div class="input-group mb-4">
              <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
              <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>

            <label class="form-label">Password</label>
            <div class="input-group mb-4">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>

            <label class="form-label">Role</label>
            <div class="input-group mb-4">
              <span class="input-group-text"><i class="bi bi-shield-fill"></i></span>
              <select name="role" class="form-control">
                <option value="student">Student</option>
                <option value="admin">Admin</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary btn-main w-100"><i class="bi bi-person-plus-fill"></i> Register</button>
            <p class="text-center mt-3 mb-0">Already have an account? <a href="login.php">Login</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
