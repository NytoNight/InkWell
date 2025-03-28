<?php
session_start();
require_once "./functions/database_functions.php";

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $zip_code = trim($_POST['zip_code']);
    $country = trim($_POST['country']);

    $conn = db_connect();
    $query = "INSERT INTO users (name, email, password, address, city, zip_code, country) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $name, $email, $password, $address, $city, $zip_code, $country);

    if ($stmt->execute()) {
        $_SESSION['user'] = ['name' => $name, 'email' => $email];
        header("Location: index.php");
        exit;
    } else {
        $error = "Registration failed. Please try again.";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap/css/styles.css" rel="stylesheet">
    <style>
        @keyframes popup {
            from {
                transform: scale(0.5);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .popup-animation {
            animation: popup 0.5s ease-out;
        }
    </style>
</head>
<body style="background-image: url('cloud.jpg'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
<div class="row justify-content-center my-5">
    <div class="col-lg-4 col-md-6 col-sm-10 col-xs-12">
        <div class="card rounded-0 shadow fade-in" style="background-color: #f1dbdd;">
            <div class="card-header">
                <div class="card-title text-center h4 fw-bolder">User Registration</div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger rounded-0"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="post" action="register.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control rounded-0" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control rounded-0" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control rounded-0" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control rounded-0">
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" class="form-control rounded-0">
                        </div>
                        <div class="mb-3">
                            <label for="zip_code" class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" class="form-control rounded-0">
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" name="country" class="form-control rounded-0">
                        </div>
                        <div class="mb-3 d-grid">
                            <button type="submit" name="register" class="btn btn-primary rounded-0">Register</button>
                        </div>
                        <p class="text-center">Already have an account? <a href="login.php" class="text-decoration-none">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./bootstrap/js/jquery-3.6.0.min.js"></script>
<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
