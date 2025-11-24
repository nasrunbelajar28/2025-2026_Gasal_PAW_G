<?php
session_start();
if (isset($_SESSION['user'])) { header('Location: dashboard.php'); exit; }
?>
<!doctype html>
<html>
<head><title>Login Sistem</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-dark d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow" style="width: 400px;">
        <div class="card-header bg-primary text-white text-center"><h4>Login Sistem</h4></div>
        <div class="card-body">
            <?php if (isset($_GET['msg'])) echo "<div class='alert alert-danger'>{$_GET['msg']}</div>"; ?>
            <form action="login_process.php" method="post">
                <div class="form-group"><label>Username</label><input type="text" name="username" class="form-control" required></div>
                <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>