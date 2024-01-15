<?php

$conn = new mysqli('localhost', 'root', '', 'auth', '3307');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $employeeId = $_GET['id'];
    $sql = "DELETE FROM employee_info WHERE id = $employeeId";

    if ($conn->query($sql) === TRUE) {
        header("Location: home.php");
    } else {
        echo 'Error deleting record: ' . $conn->error;
    }

} else {
    echo 'Invalid request.';
}

$conn->close();

?>