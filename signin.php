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
            $username = $_POST['username'];
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
                    if (!isset($_POST['favorite_animal'])) {
                        $pdp = 'img/pdp/fox.jpg';
                    } else {
                        $pdp = "img/pdp/".$_POST['favorite_animal'].".jpg";
                    }
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
    <section class="container">
        <section class="signin-form">
            <h2 class="title">Create an account</h2>
            <form action="" method="POST">
                <!-- Username - Password - Pdp -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="input" placeholder="Enter a username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="input" placeholder="Enter a password">
                </div>
                <div class="form-group">
                    <label for="password2">Confirm Password</label>
                    <input type="password" name="password2" id="password2" class="input" placeholder="Enter your password again">
                </div>
                <div class="form-group">
                    <label>Which one do you prefer ?</label>
                    <div class="radio-container">
                        <div class="radio">
                            <label for="eagle">Eagle</label>
                            <input type="radio" name="favorite_animal" id="eagle">
                        </div>
                        <div class="radio">
                            <label for="wolf">Wolf</label>
                            <input type="radio" name="favorite_animal" id="wolf" value="wolf">
                        </div>
                        <div class="radio">
                            <label for="fox">Fox</label>
                            <input type="radio" name="favorite_animal" id="fox">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" name="signin" class="btn" value="Validate">
                </div>
            </form>
        </section>
    </section>
</body>
</html>