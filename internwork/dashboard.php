<?php
include "auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Library App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Custom style -->
</head>
<body class="dashboard-bg">
    <div class="container content-box">
        <div class="card dashboard-card">
            <h2 class="welcome-text">📚 Welcome, <?=htmlspecialchars($_SESSION['user'])?>!</h2>
            <div class="d-grid gap-3">
                <a href="add.php" class="btn btn-success btn-lg">➕ Add New Book</a>
                <a href="view.php" class="btn btn-info btn-lg text-white">📚 View All Books</a>
                <a href="logout.php" class="btn btn-danger btn-lg">🚪 Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
