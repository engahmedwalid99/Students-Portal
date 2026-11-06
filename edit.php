<?php
session_start();
include 'auth_check.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: student.php");
    exit();
}
include 'config.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    header("Location: index.php");
    exit();
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = clean($_POST['name'] ?? '');
    $score = $_POST['score'] ?? '';

    if ($name === '' || !is_numeric($score)) {
        $msg = "<div class='alert alert-danger'>Please enter a valid name and score.</div>";
    } else {
        $upd = $pdo->prepare("UPDATE students SET name = ?, score = ? WHERE id = ?");
        $upd->execute([$name, (int)$score, $id]);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php'; ?>

<div class="container mb-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-9">
      <div class="app-card">
        <div class="card-head bordered">
          <div class="icon-box"><i class="bi bi-person-fill-gear"></i></div>
          <div>
            <h4>Update Student</h4>
            <small>Update information for <?= htmlspecialchars($student['name']) ?></small>
          </div>
        </div>
        <div class="card-body-pad pt-4">
          <?= $msg ?>
          <form method="POST">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">

            <label class="form-label">Student Name</label>
            <div class="input-group mb-4">
              <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
              <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required>
            </div>

            <label class="form-label">Score</label>
            <div class="input-group mb-4">
              <span class="input-group-text"><i class="bi bi-star-fill text-warning"></i></span>
              <input type="number" name="score" class="form-control" value="<?= (int)$student['score'] ?>" required>
            </div>

            <div class="row g-3">
              <div class="col-6">
                <button type="submit" class="btn btn-primary btn-main w-100"><i class="bi bi-pencil-square"></i> Update</button>
              </div>
              <div class="col-6">
                <a href="index.php" class="btn btn-outline-danger btn-main w-100"><i class="bi bi-arrow-left"></i> Back</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
