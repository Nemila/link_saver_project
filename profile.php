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
        <section class="profile-wrapper">
            <aside class="profile-nav">
                <div class="pdp-container">
                    <div class="pdp-wrapper"><img src="<?php echo $rep['pdp']; ?>" alt="profile picture" class="pdp"></div>
                    <h3 class="username"><?php echo $rep['username']; ?></h3>
                    <div class="linkDiv"><img src="img/linkBlack.png" alt="link icon" width="24px"> <?php echo $rep['links']; ?></div>
                </div>
                <div class="res-container">
                    <a href=""></a>
                </div>
            </aside>
            <aside class="profile-content">
                <div class="about-sec">
                    <h3 class="title">Biographie</h3>
                    <p class="text"><?php echo $rep['bio']; ?></p>
                </div>
            </aside>
        </section>        
    </section>
    <script src="app.js"></script>
</body>
</html>





<!--
    <section class="profile-wrapper">
                <section class="header">
                <?php// if(isset($_SESSION['user']) AND $_SESSION['user'] == $username):?>
                        <button class="settings-btn"><img src="img/settings.svg" alt="settings icon" class="setting-img"></button>
                    <?php //endif ?>
                </section>
                <section class="body">
                    <div class="pdp-div"><img src="<?php //$rep = get_others_data($db, $username); echo $rep['pdp'];?>" class="pdp"></div>
                    <div class="text-wrapper">
                        <h3 class="username"><?php //echo $rep['username']; ?></h3>
                        <p class="bio"><?php// echo $rep['bio']; ?></p>
                        <div class='link'><img src="img/link.png" alt="link icon" width="24px"> <p class="link-text"><?php echo $rep['links']; ?></p></div>
                    </div>
                </section>
            </section>
            
           <?php// if(isset($_SESSION['user']) AND $_SESSION['user'] == $username):?>
                <section class="settings-wrapper">
                    <button class="settings-btn"><img src="img/exit.png" alt="settings icon" class="setting-img"></button>
                    <h3 class="setting-title">Modify your profile</h3>
                    <form action="" method="POST" class="setting-form">
                        <div class="form-group">
                            <label for="pdp">Profile image link</label>
                            <input type="text" class="input" id='pdp' name="pdp_link">
                        </div>
                        <div class="form-group">
                            <label for="bio">Biographie</label>
                            <textarea name="bio" id="bio" cols="30" rows="10" class="input"><?php// echo $rep['bio'];?></textarea>
                        </div>
                        <button class="btn" name="modify">Modify</button>
                    </form>
                </section>
            <?php //endif ?>
            </div>
    </section>
            -->