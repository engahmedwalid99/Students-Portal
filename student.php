<?php
include 'auth_check.php';
include 'config.php';

$q = clean($_GET['q'] ?? '');
$results = [];
$searched = isset($_GET['q']);

if ($searched) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE name LIKE ? ORDER BY id ASC");
    $stmt->execute(["%$q%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Search Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php'; ?>

<div class="container mb-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="app-card">
        <div class="card-head bordered">
          <div class="icon-box"><i class="bi bi-search"></i></div>
          <div>
            <h4>Search Student</h4>
            <small>Find a student's result by name</small>
          </div>
        </div>
        <div class="card-body-pad pt-4">
          <form method="GET" class="d-flex gap-2 mb-4">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
              <input type="text" name="q" class="form-control" placeholder="Enter student name"
                     value="<?= htmlspecialchars($q) ?>" required>
            </div>
            <button class="btn btn-primary px-4" type="submit"><i class="bi bi-search"></i> Search</button>
          </form>

          <?php if ($searched): ?>
            <?php if ($results): ?>
              <div class="table-responsive">
                <table class="table students-table">
                  <thead><tr><th>#</th><th>Student</th><th>Score</th><th>Status</th></tr></thead>
                  <tbody>
                  <?php foreach ($results as $s): [$label, $cls] = getStatus($s['score']); ?>
                    <tr>
                      <td><?= $s['id'] ?></td>
                      <td class="name"><?= htmlspecialchars($s['name']) ?></td>
                      <td><span class="score-badge"><?= (int)$s['score'] ?></span></td>
                      <td><span class="status-badge <?= $cls ?>"><?= $label ?></span></td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <div class="alert alert-warning mb-0">No student found.</div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
