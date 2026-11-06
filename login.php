<?php
session_start();
include 'config.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: index.php");
        } else {
            header("Location: student.php");
        }
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Student System</title>
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
          <div class="icon-box"><i class="bi bi-box-arrow-in-right"></i></div>
          <div>
            <h4>Login</h4>
            <small>Sign in to your account</small>
          </div>
        </div>
        <div class="card-body-pad pt-4">
          <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
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

            <button type="submit" class="btn btn-primary btn-main w-100"><i class="bi bi-box-arrow-in-right"></i> Login</button>
            <p class="text-center mt-3 mb-0">No account? <a href="register.php">Register</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
