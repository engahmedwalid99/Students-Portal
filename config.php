<?php

$host    = 'localhost';
$dbname  = 'school_db';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

function clean($value) {
    return trim(strip_tags((string)$value));
}

function getStatus($score) {
    $score = (int)$score;
    if ($score > 100 || $score < 0) return ['Error', 'st-error'];
    if ($score >= 90) return ['Excellent+', 'st-excellent-plus'];
    if ($score >= 80) return ['Excellent', 'st-excellent'];
    if ($score >= 70) return ['Very Good', 'st-verygood'];
    if ($score >= 60) return ['Good', 'st-good'];
    return ['Fail', 'st-fail'];
}
?>
