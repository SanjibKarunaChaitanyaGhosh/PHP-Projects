<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $skills = htmlspecialchars($_POST['skills']);

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid Email");
    }

    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        die("Invalid Phone");
    }

    // File upload
    $targetDir = "uploads/";
    $fileName = time() . "_" . basename($_FILES["resume"]["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($fileType != "pdf") {
        die("Only PDF allowed");
    }

    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFile)) {

        $sql = "INSERT INTO users (name, email, phone, skills, resume)
                VALUES ('$name', '$email', '$phone', '$skills', '$fileName')";

        if ($conn->query($sql)) {
            header("Location: success.php");
        } else {
            echo "Database error";
        }

    } else {
        echo "File upload error";
    }
}
?>