<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="design.css">
</head>
<body>
    <form id="loginForm" method="GET" action="connection.php">

        <label for="email">Email:</label>  
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
        <p>If not a user. Then goes to the <a href="registration.php">Registration</a> page</p>
        
    </form>
</body>
</html>