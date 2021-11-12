<?php
    // Dtabase and general functions
    include "db.php";

    // Edit profile bio
    if (isset($_POST['edit'])) {
        $bio = $_POST['bio'];
        $req = $db->prepare("UPDATE users SET bio=:bio WHERE username=:username");
        $req->execute([
            ':bio' => $bio, 
            ':username' => $_SESSION['user']
        ]);
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
    <!-- navbar -->
    <?php include "navbar.php"; ?>

    <?php if (isset($_GET['user']) AND (get_others_data($db, $_GET['user']) > 0)){ ?>
        <?php 
            $username = $_GET['user']; 
            $rep = get_others_data($db, $username);
        ?>
        <section class="main container-fluid d-flex justify-content-center align-items-center">
            <section class="profile-card">
                <div class="profile-ban-color"></div>
                <div class="profile-body">
                    <img src="<?php echo $rep['pdp']; ?>" alt="pdp" class="user-pdp" width="100px">
                    <div class="profil-content">
                        <h3 class="user-name"><?php echo $rep['username']; ?></h3>
                        <p class="bio"><?php echo $rep['bio']; ?></p>
                        <div class="profile-footer"><a href="links.php?linksof=<?php echo $rep['username']; ?>" class="profile-link"><i class="fas fa-link"></i> <?php echo $rep['links']; ?></a></div>
                    </div>
                </div>
                <?php if (isset($_SESSION['user']) AND $_SESSION['user'] == $username):?>
                    <button class="profile_edit_btn"><i class="fas fa-cog"></i></button>
                <?php endif; ?>
            </section>
        </section>
        <?php if ($_SESSION['user'] == $username):?>
            <div class="container edit_profile_form is_hide">
                <div class="row col-md-12">
                    <form action="" method="POST" class="bg-light p-4 col-md-12">
                        <div class="mb-3">
                            <label for="bio" class="form-label">Biography</label>
                            <textarea class="bio_edit form-control" id="bio" name="bio" cols="5" rows="5"><?php echo $rep['bio']; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark" name="edit">Submit</button>
                    </form>
                </div>  
            </div>
        <?php endif; ?>
    <?php } else { ?>
        <div class="container text-danger text-center error-msg"><h2><i class="fas fa-exclamation-triangle"></i> Aucun utilisateur specifie ou cet utilisateur n'existe pas <i class="fas fa-exclamation-triangle"></i></h2></div>
    <?php } ?>
    <script src="app.js"></script>
</body>
</html>
