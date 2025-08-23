<?php
include "auth.php";
include "db.php";

$id = $_GET['id'] ?? 0;
$msg="";

$result = $conn->query("SELECT * FROM books WHERE id=$id");
if($result->num_rows !==1){
    die("❌ Book not found.");
}
$book = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $titles=$_POST['titles'];
    $author=$_POST['author'];
    $year = $_POST['year'];

    $sql = "UPDATE books SET titles = '$titles', author='$author' ,year='$year' WHERE id=$id";
    if($conn->query($sql)){
        $msg = "✅ Book updated successfully!";
        $result = $conn->query("SELECT * FROM books WHERE id=$id");
        $book = $result->fetch_assoc();
    }else{
        $msg="❌ Update failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book | Library App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="style.css">
</head>
<body class="edit-page-bg">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="mb-3">✏️ Edit Book</h2>
            <?php if($msg): ?>
                <div class="alert alert-info"><?=$msg ?></div>
            <?php endif;?>

            <form method="POST">
                 <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input name="author" value="<?=htmlspecialchars($book['author']) ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Book Title</label>
                    <input name="titles"  value="<?=htmlspecialchars($book['titles'])?>" type="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">year</label>
                    <input name="year" value="<?=htmlspecialchars($book['year']) ?>" class="form-control">
                </div>

                <button class="btn btn-primary">Update Book</button>
                <a href="view.php" class="btn btn-secondary ms-2">⬅ Back</a>
            </form>
        </div>
    </div>
</body>
</html>