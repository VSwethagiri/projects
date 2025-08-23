<?php
include "db.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $skills = $_POST['skills'] ?? '';
    $bio = $_POST['bio'] ?? '';

    $sql = "INSERT INTO users(name,email,phone,gender,skills,bio)
             VALUES('$name','$email','$phone','$gender','$skills','$bio')";
    if ($conn->query($sql)===TRUE){
        echo "<h2> Thank you , $name!</h2>
        <p>Your information has been saved to the database successfully</p>";

    }
    else{
        echo "Error : ". $conn->error;
    }
    $conn->close();
 }
?>