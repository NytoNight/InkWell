<?php
session_start();
require_once "./functions/database_functions.php";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $conn = db_connect();
    $query = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $result->fetch_assoc();
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
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
        <div class="card rounded-0 shadow popup-animation" style="background-color: #f1dbdd;">
            <div class="card-header">
                <div class="card-title text-center h4 fw-bolder">User Login</div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger rounded-0"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="post" action="login.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control rounded-0" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control rounded-0" required>
                        </div>
                        <div class="mb-3 d-grid">
                            <button type="submit" name="login" class="btn btn-primary rounded-0">Login</button>
                        </div>
                        <p class="text-center">Don't have an account? <a href="register.php" class="text-decoration-none">Register here</a></p>
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
