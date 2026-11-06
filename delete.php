<?php
session_start();
include 'auth_check.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: student.php");
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
}
header("Location: index.php");
exit();
?>
