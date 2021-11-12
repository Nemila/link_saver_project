<?php 
    include "db.php";  
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- navbar -->
    <?php include "navbar.php"; ?>

    <!-- Header -->
    <header class="container-fluid d-flex text-center justify-content-center align-items-center text-light">
        <div class="text-wrapper">
            <h1 class="title">Welcome to Link Saver</h1>
            <p class="description">Create an account or login to never lose your links againt</p>
        </div>
    </header>

    <div class="container hero">
        <h3 class="hero-title">Top users</h3>
        <div class="row">
            <?php $req = $db->query("SELECT * FROM users ORDER BY links DESC"); while($rep = $req->fetch()): ?>
                <div class="col-md-4 member-block m-md-1 p-5 bg-dark text-light">
                    <img src="<?php echo $rep['pdp']; ?>" alt="profil picture" width="100px" class="member-block-pdp">
                    <h3 class="my-3"><?php echo $rep['username']; ?></h3>
                    <p href="links.php?linksof=<?php echo $rep['username']; ?>" class="profile-link"><i class="fas fa-link"></i> <?php echo $rep['links']; ?></p>
                    <a href="profile.php?user=<?php echo $rep['username']; ?>" class="btn btn-success">Profile</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>