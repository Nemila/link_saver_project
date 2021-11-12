<?php
    session_start();
    $dbhost = "localhost";
    $dbname = "link_saver";
    $dbuser = "root";
    $dbpass = "";
    $db = new PDO("mysql:host=$dbhost; dbname=$dbname; charset=utf8", $dbuser, $dbpass);

    function get_user_data($db) {
        if (isset($_SESSION['user'])) {
            $req = $db->prepare("SELECT * FROM users WHERE username=:username");
            $req->execute([
                ':username' => $_SESSION['user']
            ]);
            return $req->fetch();
        }
    }
    function get_others_data($db, $username) {
        $req = $db->prepare("SELECT * FROM users WHERE username=:username");
        $req->execute([
            ':username' => $username
        ]);
        return $req->fetch();
    }
    function change_link_number($db, $user) {
        $req=$db->prepare("SELECT * FROM links WHERE link_user=:username");
        $req->execute([
            ":username" => $user
        ]);
        $link_number = $req->rowCount();
        $req=$db->prepare("UPDATE users SET links=:link_number WHERE username=:username");
        $req->execute([
            ":link_number" => $link_number,
            ":username" => $user
        ]);
    }
?>