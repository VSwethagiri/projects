<?php
include "db.php"; 

$username = "swe";
$password = "123";

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert into users table
$sql = "INSERT INTO studentusers (username, password) VALUES ('$username', '$hashedPassword')";
if (mysqli_query($conn, $sql)) {
    echo "✅ User '$username' created successfully!";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}

?>
