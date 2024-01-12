<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "auth";
    $table = "register";
    $port = "3307";

    $conn = new mysqli($host, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_GET["email"];
    $password = $_GET["password"];

    $sql = "SELECT * FROM $table WHERE email = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
 

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION['user_email'] = $email;
            
            header("Location: home.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }

    $stmt->close();
    $conn->close();
}
?>
