<nav class="navbar">
    <div class="logo">
        <a href="index.php" class="nav-link logo-link">LSaver</a>
    </div>
    <ul class="nav">
        <li class="nav-item">
            <a href="index.php" class="nav-link">Home</a>
        </li>
        <?php if (isset($_SESSION['user'])){ ?>
            <li class="nav-item">
                <a href="profile.php?user=<?php echo $_SESSION['user']; ?>" class="nav-link">Profile</a>
            </li>
            <li class="nav-item">
                <a href="logout.php?" class="nav-link">Logout</a>
            </li>
        <?php } else { ?>
            <li class="nav-item">
                <a href="login.php" class="nav-link">Login</a>
            </li>
            <li class="nav-item">
                <a href="signin.php" class="nav-link">Signin</a>
            </li>
        <?php } ?>
    </ul>
</nav>