<?php
include "auth.php";
include "db.php";

$msg="";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $titles = $_POST['titles'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    //convert to array
    $titlearray=array_map('trim',explode(',',$titles));
    $titlejson=json_encode($titlearray);

    $stmt = $conn->prepare("INSERT INTO books (titles, author, year) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $titles, $author, $year); // s = string, s = string, i = integer

    if ($stmt->execute()) {

        header("Location: view.php?added=1");
    }
    else
        {
        $msg = "❌ Error: " . $conn->error;

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book | Library App<</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="style.css">
</head>
<body class="edit-page-bg">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="mb-3">➕ Add a New Book</h2>
            <?php if($msg): ?>
                <div class="alert alert-info"><?=$msg?></div>
            <?php endif;?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input name="author" type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Book Title</label>
                    <input name="titles" type="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Year</label>
                    <input name="year" type="number" class="form-control">
                </div>

                <button class="btn btn-success">Add Book</button>
                <a href="dashboard.php" class="btn btn-secondary ms-2">⬅ Back</a>
            </form>
        </div>
    </div>
</body>
</html>