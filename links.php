<?php 
    // Database and general functions
    include "db.php";  
    $title = "links";

    // Page verifications
    if (isset($_GET['linksof']) AND !empty($_GET['linksof'])) {
        $username = $_GET['linksof'];
    } else {
        header('location: index.php');
    }

    // Form to add new link
    if (isset($_POST['add_link'])) {
        // Set variables
        $name = strtolower($_POST['link_title']);
        $link = $_POST['link_add'];
        $user_link = $_SESSION['user'];
        $state = $_POST['state'];

        // Check if link already exist
        $req=$db->prepare("SELECT * FROM links WHERE link_user=:username AND link=:link");
        $req->execute([
            ':username' => $_SESSION['user'],
            ':link' => $link
        ]);
        if (($rep=$req->fetch()) <= 0){
            // Adding the new link
            $req=$db->prepare("INSERT INTO links (link_user, link, link_name, public) VALUES (:user_link, :link, :link_name, :public)");
            $req->execute([
                ":user_link" => $user_link,
                ":link" => $link,
                ":link_name" => $name,
                ":public" => $state
            ]);
            // Change the number of link for the user
            change_link_number($db, $_SESSION['user']);
        } else {
            echo "Link already exist. Link Name: ".$rep['link_name'];
        }
    }

    // Form to delete a link
    if (isset($_POST['delete_link'])) {
        $link_name = $_POST['link_to_del'];
        $req = $db->prepare("DELETE FROM links WHERE link_name=:link_name AND link_user=:user");
        $req->execute([
            ':link_name' => $_POST['link_to_del'],
            ':user' => $_SESSION['user']
        ]);
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="links.css">
</head>
<body>
    <!-- navbar -->
    <?php include "navbar.php"; ?>
    <!-- section -->
    <section class="main container">
        <?php if (isset($_SESSION['user']) AND $_SESSION['user'] == $username): ?>
            <div class="row">
                <div class="col-md-4">
                    <h3>Add a new link</h3>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="link_title" class="form-label">Link title</label>
                            <input type="text" class="form-control" id="link_title" name="link_title">
                        </div>
                        <div class="mb-3">
                            <label for="link_add" class="form-label">Link addrese</label>
                            <input type="text" class="form-control" id="link_add" name="link_add">
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">Make it public ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="yes" name="state" id="public">
                                <label class="form-check-label" for="public" checked>
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="no" name="state" id="private">
                                <label class="form-check-label" for="private">
                                    No
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_link">Submit</button>
                    </form>
                </div>
                <div class="col-md-4 my-4">
                    <h3>Deleted a new link</h3>
                    <form action="" method="POST">
                        <?php $req=$db->prepare("SELECT * FROM links WHERE link_user=:user"); $req->execute([':user'=>$_SESSION['user']]); ?>
                        <div class="mb-3">
                            <label for="link_sel" class="form-label">Select</label>
                            <select name="link_to_del" id="link_sel" class="form-control">
                                <?php while($rep = $req->fetch()): ?>    
                                    <option value="<?php echo $rep['link_name'] ?>"><?php echo $rep['link_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger" name="delete_link">Submit</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        
        <section class="container link-cont">
            <div class="row">
                <h3 class="title">Links of <?php echo $_GET['linksof']; ?></h3>
                <?php
                    if (isset($_SESSION['user']) AND $_SESSION['user'] != $_GET['linksof']) {
                        $req =$db->prepare("SELECT * FROM links WHERE link_user=:username AND public='yes'");
                    } else {
                        $req =$db->prepare("SELECT * FROM links WHERE link_user=:username");
                    }
                    $req->execute([
                        ':username' => $username
                    ]);
                ?>
                <?php while($rep=$req->fetch()): ?>
                    <div class="link-bloc col-md-4 m-1 p-3 bg-dark text-light">
                        <p><?php echo $rep['link_name']; ?></p>
                        <a href="<?php echo $rep['link']; ?>" name="add_link" class="btn btn-success">Go</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </section>
</body>
</html>