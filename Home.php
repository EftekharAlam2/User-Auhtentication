<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "auth";
$port = "3307";

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $address = $_POST["address"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $image = $_FILES["image"]["name"];
    $temp = $_FILES["image"]["tmp_name"]; 
    $file = "images/" . $image;

    move_uploaded_file($temp, $file);


    if (!preg_match('/^[a-zA-Z ]+$/', $name)) {
        echo "Invalid name format. Name should contain only letters and spaces.";
        $conn->close();
        exit();
    }

    if (!is_numeric($number)) {
        echo "Invalid phone number format. Please enter only numeric characters.";
        $conn->close();
        exit();
    }

    if ($result->num_rows > 0) {
        echo "Error: Email already exists. Please choose a different email.";
        $conn->close();
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[^0-9]*[a-zA-Z0-9._-]*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)) {
        echo "Invalid email format";
        $conn->close();
        exit();
    }

    $sql = "INSERT INTO employee_info (name, email, number,  address, dob, gender, image) 
            VALUES ('$name', '$email', '$number', '$address', '$dob', '$gender', '$image')";

    if ($conn->query($sql) === TRUE) {
        header("Location: home.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="m-5">
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Add Employee Info
        </button>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" >
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="number" >
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" name="address">
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="male" name="gender" value="Male" required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="female" name="gender" value="Female" required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
                <div class="mb-3 text-center">
                    <label class="form-label">Employee Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "auth";
            $port = "3307";
            
            $conn = new mysqli($servername, $username, $password, $dbname, $port);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = $conn->query("SELECT * FROM employee_info");

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['number']}</td>";
                echo "<td>{$row['address']}</td>";
                echo "<td>{$row['dob']}</td>";
                echo "<td>{$row['gender']}</td>";
                echo "<td><img src='images/{$row['image']}' style='max-width: 100px; max-height: 100px;'></td>";
                echo "<td>
                        <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            
        ?>

        </tbody>
    </table>

    <form method="post" action="logout.php">
        <button class="btn btn-info" type="submit" name="logout">Logout</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>