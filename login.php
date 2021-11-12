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
            $username = strtolower($_POST['username']);
            $password = $_POST['password'];

            $req = $db->prepare('SELECT * FROM users WHERE username=:username');
            $req->execute([
                ':username' => $username
            ]);
            if (($rep = $req->fetch()) > 0) {
                if (password_verify($password, $rep['user_password'])) {
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
    <section class="main container-fluid d-flex justify-content-center align-items-center">
        <section class="login-form col-md-4">
            <h2 class="title">Log-in</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass" name="password">
                </div>
                <button type="submit" class="btn btn-dark" name="login">Submit</button>
            </form>
        </section>
    </section>
</body>
</html>