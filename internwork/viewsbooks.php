<?php
include "db.php";
session_start();

// Check if student logged in
$isStudent = isset($_SESSION['user']);
$studentName = $_SESSION['user'];


// Debug session




// Handle booking
if ($isStudent && isset($_GET['book_id'])) {
    $bookId = intval($_GET['book_id']);
   
    // Prevent double booking
    $check = $conn->query("SELECT booked_by FROM books WHERE id=$bookId");
    $row = $check->fetch_assoc();
    if ($row['booked_by'] == null) {
        $conn->query("UPDATE books SET booked_by='$studentName' WHERE id=$bookId");
    }
    header("Location: viewsbooks.php");
    exit();
}

$books = $conn->query("SELECT * FROM books ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books | Library App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="view-books-bg">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="mb-3">📖 All Books</h2>
        <?php if($books->num_rows>0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Titles</th>
                        <th>Author</th>
                        <th>Year</th>
                        <th>Status</th>
                        <?php if($isStudent): ?><th>Action</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while($book = $books->fetch_assoc()):?>
                        <tr>
                            <td><?= $book['id'] ?></td>
                            <td>
                                <?php 
                                $titles=json_decode($book['titles'],true);
                                echo is_array($titles)?implode(",",$titles):htmlspecialchars($book['titles']); 
                                ?>
                            </td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['year']) ?></td>
                            <td>
                                <?php if($book['booked_by']): ?>
                                    <span class="badge bg-danger">Booked by <?= htmlspecialchars($book['booked_by']) ?></span>
                                <?php else: ?>
                                    <span class="badge bg-success">Available</span>
                                <?php endif; ?>
                            </td>
                            <?php if($isStudent): ?>
                                <td>
                                    <?php if(!$book['booked_by']): ?>
                                        <a href="viewsbooks.php?book_id=<?= $book['id'] ?>" class="btn btn-sm btn-warning">Book</a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary" disabled>Already Booked</button>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No Books Found. <a href="add.php">Add one?</a></p>
        <?php endif; ?>

        <a href="dashboardstu.php" class="btn btn-secondary mt-3">⬅ Back to Dashboard</a>
    </div>
</div>
</body>
</html>
