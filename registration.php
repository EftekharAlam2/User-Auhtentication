<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "auth";
    $table = "register";
    $port="3307";

    $conn = new mysqli($host, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $address = $_POST["address"];
    $dob = $_POST["dob"];

    $emailCheckQuery = "SELECT * FROM $table WHERE email = '$email'";
    $result = $conn->query($emailCheckQuery);

    if ($result->num_rows > 0) {
        echo "Error: Email already exists. Please choose a different email.";
        $conn->close();
        exit();
    }

    // if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z_]+[a-zA-Z0-9._-]*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)) {
    //     echo "Invalid email format";
    //     $conn->close();
    //     exit();
    // }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[^0-9]*[a-zA-Z0-9._-]*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)) {
        echo "Invalid email format";
        $conn->close();
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO $table (name, email, phone, password, address, dob) VALUES ('$name', '$email', '$phone', '$hashedPassword', '$address', '$dob')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <form id="loginForm" method="POST" action="registration.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>  
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="number" id="phone" name="phone" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" required></textarea>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>

        <button type="submit">Registration</button>

        <p>Regestration successful. Then goes to the <a href="login.php">Login</a> page</p>
    </form>
</body>
</html>