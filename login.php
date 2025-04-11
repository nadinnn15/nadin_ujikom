<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
     body {
    background-color: #80B9AD;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    width: 100%;
    max-width: 400px;
}

.card {
    background-color: #F3F7EC;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    padding: 30px 25px;
    border: none;
}

.card-body {
    padding: 0;
}

.login-header {
    text-align: center;
    margin-bottom: 20px;
}

.login-header img {
    max-width: 80px;
    margin-bottom: 10px;
}

.card h2 {
    text-align: center;
    color: #504B38;
    font-weight: bold;
    margin-bottom: 25px;
}

.form-group label {
    color: #504B38;
    font-weight: 500;
}

.form-control {
    border-radius: 30px;
    border: 1px solid #6295A2;
    padding: 10px 20px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
    border-color: #538392;
    box-shadow: 0 0 8px rgba(80, 75, 56, 0.2);
}

.btn-primary {
    background-color: #80B9AD;
    border: none;
    border-radius: 30px;
    padding: 10px;
    font-weight: 600;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-primary:hover {
    background-color: #6295A2;
    transform: scale(1.02);
}

.alert {
    border-radius: 10px;
    font-size: 0.95rem;
}

</style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 login-container">
                <div class="login-header">
                    <?php if (file_exists('logo.png')): ?>
                        <img src="logo.png" alt="Logo">
                    <?php endif; ?>
                </div>
                <div class="card">
    <div class="card-body">
        <div class="login-header">
            <?php if (file_exists('logo.png')): ?>
                <img src="logo.png" alt="Logo">
            <?php endif; ?>
            <h2>Login</h2>
        </div>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        <form action="proses_login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
</div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>