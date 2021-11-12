<?php
    //Database
    include "db.php"; 
    // Redirect
    if (isset($_SESSION['user'])) {
        header('location:index.php');
    }
    //Signin
    if (isset($_POST['signin'])){
        if (!empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['password2'])) {
            $username = strtolower($_POST['username']);
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            // If username already exist
            $req = $db->prepare('SELECT * FROM users WHERE username=:username');
            $req->execute([
                ':username' => $username
            ]);
            if ($req->fetch() > 0) {
                echo "Username exist already";
            } else {
                if ($password != $password2) {
                    echo 'Passwords are differents';
                } else {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $pdp = "https://avatars.dicebear.com/api/adventurer-neutral/$username.svg";
                    $req = $db->prepare("INSERT INTO users (username, user_password, pdp, bio, links) VALUES (:username, :user_password, :pdp, :bio, :links)");
                    $req->execute([
                        ':username' => $username,
                        ':user_password' => $password,
                        ':pdp' => $pdp,
                        ':bio' => 'No bio yet...',
                        ':links' => 0
                    ]);
                    $_SESSION['user'] = $username;
                    header('location:index.php');
                }
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
        <section class="signin-form col-md-4">
            <h2 class="title">Sign-in</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass" name="password">
                </div>
                <div class="mb-3">
                    <label for="pass2" class="form-label">Comfirm Password</label>
                    <input type="password" class="form-control" id="pass2" name="password2">
                </div>
                <button type="submit" class="btn btn-dark" name="signin">Submit</button>
            </form>
        </section>
    </section>
</body>
</html>