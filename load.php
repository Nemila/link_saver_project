<?php
    include "db.php";
    header("location:profile.php?user=".$_SESSION['user']); 
?>