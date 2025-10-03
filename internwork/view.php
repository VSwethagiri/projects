<?php
include "auth.php";
include "db.php";
if (isset($_GET['return_id'])) {
    $bookId = intval($_GET['return_id']);
    $conn->query("UPDATE books SET booked_by=NULL WHERE id=$bookId");
    header("Location: view.php");
    exit();
}

$books = $conn->query("SELECT * FROM books ORDER BY id ASC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books | Library App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>

<body class="view-books-bg">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="mb-3">📖 All Books</h2>
            <?php if ($books->num_rows > 0): ?>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Titles</th>
                            <th>Author</th>
                            <th>Year</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Return</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($book = $books->fetch_assoc()): ?>
                            <tr>
                                <td><?= $book['id'] ?></td>
                                <td><?= $titles = json_decode($book['titles'], true);
                                echo is_array($titles) ? implode(",", $titles) : htmlspecialchars($book['titles']); ?>
                                </td>
                                <td><?= htmlspecialchars($book['author']) ?></td>
                                <td><?= htmlspecialchars($book['year']) ?></td>
                                <td>
                                    <?php if (!empty($book['booked_by'])): ?>
                                        <span class="badge bg-danger">Booked by <?= htmlspecialchars($book['booked_by']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Available</span>
                                    <?php endif; ?>
                                </td>
                                <td><a href="edit.php?id=<?= $book['id'] ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                <td><a href="delete.php?id=<?= $book['id'] ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this book?');">Delete</a></td>
                                <td>
                                    <?php if (!empty($book['booked_by'])): ?>
                                        <a href="view.php?return_id=<?= $book['id'] ?>" class="btn btn-sm btn-success"
                                            onclick="return confirm('Mark this book as returned?');">✅ Return</a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p> No Bookd Found .<a href="add.php">Add one?</a></p>
            <?php endif; ?>

            <a href="dashboard.php" class="btn btn-secondary mt-3">⬅ Back to Dashboard</a>
        </div>
    </div>
</body>

</html>