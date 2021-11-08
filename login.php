<?php 
    //Database
    include "db.php";
    //Redirect
    if (isset($_SESSION['user'])) {
        header('location:index.php');
    }
    //Login 
    if (isset($_POST['login'])) {
        if (!empty($_POST['username']) AND !empty($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $req = $db->prepare('SELECT * FROM users WHERE username=:username');
            $req->execute([
                ':username' => $username
            ]);
            if (($rep = $req->fetch()) > 0) {
                if ($rep['user_password'] == $password) {
                    $_SESSION['user'] = $username;
                    header('location:index.php');
                } else {
                    echo 'Incorrect password';
                }
            } else {
                echo "Username doesn't exits";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <!-- navbar -->
    <?php include "navbar.php"; ?>
    <!-- section -->
    <section class="container">
        <section class="login-form">
            <h2 class="title">Connect to your account</h2>
            <form action="" method="POST">
                <!-- Username - Password - Pdp -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="input" placeholder='Enter your username'>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="input" placeholder='Enter your password'>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" class="btn" value="Validate">
                </div>
            </form>
        </section>
    </section>
</body>
</html>