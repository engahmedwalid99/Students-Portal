School Portal - Student System (Unit 20 PHP Level 2 - Ahmed Walid C4
=====================================================

Files
config.php      PDO connection (try/catch) + helper functions
auth_check.php  session-protection middleware
register.php    create account (password_hash + prepared statement)
login.php       password_verify + role-based redirect
logout.php      session_unset + session_destroy
nav.php         navbar with session state (Hi, user / Logout)
index.php       admin dashboard (add + list students)
edit.php        update student
delete.php      delete student (admin only)
student.php     search student result (any logged-in user)
style.css       design
database.sql    database + tables + sample students

Score status: 90-100 Excellent+ | 80-89 Excellent | 70-79 Very Good |
              60-69 Good | below 60 Fail | above 100 Error


Tables in Database

CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  score INT NOT NULL
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','student') DEFAULT 'student'
);
