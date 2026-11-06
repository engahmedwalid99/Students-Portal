<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$loggedIn = isset($_SESSION['user_id']);
$isAdmin  = $loggedIn && ($_SESSION['role'] ?? '') === 'admin';
$homeLink = $isAdmin ? 'index.php' : ($loggedIn ? 'student.php' : 'login.php');
?>
<nav class="app-navbar">
  <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
    <a href="<?= $homeLink ?>" class="brand text-decoration-none">
      <span class="brand-logo">🎓</span>
      <span class="brand-text">Student <span>System</span></span>
    </a>

    <div class="d-flex align-items-center gap-2 flex-wrap">
      <?php if ($loggedIn): ?>
        <a href="<?= $homeLink ?>" class="nav-pill"><i class="bi bi-house-fill"></i> Home</a>
        <a href="student.php" class="nav-pill"><i class="bi bi-search"></i> Search Student</a>
        <span class="nav-user">Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" class="nav-pill nav-logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
      <?php else: ?>
        <a href="login.php" class="nav-pill"><i class="bi bi-box-arrow-in-right"></i> Login</a>
        <a href="register.php" class="nav-pill"><i class="bi bi-person-plus-fill"></i> Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
