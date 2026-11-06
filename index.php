<?php
session_start();
include 'auth_check.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: student.php");
    exit();
}

include 'config.php';
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name  = clean($_POST['name'] ?? '');
    $score = $_POST['score'] ?? '';

    if ($name === '' || !is_numeric($score)) {
        $msg = "<div class='alert alert-danger'>Please enter a valid name and score.</div>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO students (name, score) VALUES (?, ?)");
        $stmt->execute([$name, (int)$score]);
        header("Location: index.php");
        exit();
    }
}

$students = $pdo->query("SELECT * FROM students ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php'; ?>

<div class="container mb-5">
  <div class="row g-4">

    <div class="col-lg-4">
      <div class="app-card h-100">
        <div class="card-head">
          <div class="icon-box"><i class="bi bi-plus-lg"></i></div>
          <div>
            <h4>Add Student</h4>
            <small>Create a new student</small>
          </div>
        </div>
        <div class="card-body-pad">
          <div class="hero-icon"><i class="bi bi-person-plus-fill"></i></div>
          <?= $msg ?>
          <form method="POST">
            <label class="form-label">Student Name</label>
            <input type="text" name="name" class="form-control mb-4" placeholder="Enter student name" required>

            <label class="form-label">Score</label>
            <input type="number" name="score" class="form-control mb-4" placeholder="Enter score" required>

            <button type="submit" name="add" class="btn btn-primary btn-main w-100">
              <i class="bi bi-plus-lg"></i> Add Student
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="app-card h-100">
        <div class="card-head bordered"><h4>All Students</h4></div>
        <div class="table-responsive">
          <table class="table table-hover students-table">
            <thead>
              <tr><th>#</th><th>Student</th><th>Score</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
              <?php foreach ($students as $s): [$label, $cls] = getStatus($s['score']); ?>
              <tr>
                <td><?= $s['id'] ?></td>
                <td class="name"><?= htmlspecialchars($s['name']) ?></td>
                <td><span class="score-badge"><?= (int)$s['score'] ?></span></td>
                <td><span class="status-badge <?= $cls ?>"><?= $label ?></span></td>
                <td>
                  <a href="edit.php?id=<?= $s['id'] ?>" class="btn btn-outline-primary btn-act">
                    <i class="bi bi-pencil-square"></i> Edit
                  </a>
                  <form method="POST" action="delete.php" class="d-inline"
                        onsubmit="return confirm('Delete this student?');">
                    <input type="hidden" name="id" value="<?= $s['id'] ?>">
                    <button type="submit" class="btn btn-outline-danger btn-act">
                      <i class="bi bi-trash-fill"></i> Delete
                    </button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php if (!$students): ?>
              <tr><td colspan="5" class="text-muted py-4">No students yet.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
</body>
</html>
