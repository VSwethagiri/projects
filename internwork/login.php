<?php
session_start();
if(isset($_SESSION['user'])){
    header("location: dashboard.php");
    exit();
}

include "db.php";

$msg = "";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            setcookie("user", $username, time() + 3600); // 1-hour cookie
            header("Location: dashboard.php");
            exit();
        } else {
            $msg = "❌ Invalid password.";
        }
    } else {
        $msg = "❌ User not found.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Library App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> 
</head>
<body class="login-bg">
    <div class="content-box d-flex justify-content-center align-items-center">
        <div class="col-md-5 bg-white p-4 rounded shadow login-card">
            <h3 class="text-center mb-4">📚 Library Login</h3>
            <?php if($msg): ?>
                <div class="alert alert-danger"><?=$msg?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">USERNAME</label>
                    <input name="username" type="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">PASSWORD</label>
                    <input name="password" type="password" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">LOGIN</button>
            </form>
        </div>
    </div>
</body>
</html>
