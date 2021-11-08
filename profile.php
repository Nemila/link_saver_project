<?php 
    include "db.php";
    if (isset($_GET['user'])) {
        $username = $_GET['user'];
        if (get_others_data($db, $username) <= 0) {
            header('location:index.php');
        }
    } else {
        header('location:index.php');
    }
    if (isset($_POST['modify'])) {
        $img_link = $_POST['pdp_link'];
        $bio = $_POST['bio'];

        if (!empty($img_link)) {
            $req = $db->prepare("UPDATE users SET bio=:bio, pdp=:pdp WHERE username=:username");
            $req->execute([
                ':bio' => $bio, 
                ':pdp' => $img_link, 
                ':username' => $_SESSION['user']
            ]);
        } else {
            $req = $db->prepare("UPDATE users SET bio=:bio WHERE username=:username");
            $req->execute([
                ':bio' => $bio, 
                ':username' => $_SESSION['user']
            ]);
        }
        header('location:load.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <?php $rep = get_others_data($db, $username); ?>
    <!-- navbar -->
    <?php include "navbar.php"; ?>
    <!-- section -->
    <section class="container">
        <section class="profile-card">
            <header class="profile-header">
                <img src="<?php echo $rep['pdp']; ?>" alt="pdp" class="user-pdp" width="86px">
                <h3 class="user-name"><?php echo $rep['username']; ?></h3>
            </header>
            <div class="profile-body"><?php echo $rep['bio']; ?></div>
            <footer class="profile-footer"><a href="#" class="profile-link"><i class="fas fa-link"></i> <?php echo $rep['links']; ?></a></footer>
        </section>
    </section>
    <script src="app.js"></script>
</body>
</html>
