<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    
</head>
<body class="m-5">

    <form method="post" action="logout.php">
        <button class="btn btn-info" type="submit" name="logout">Logout</button>
    </form>

</body>
</html>