<nav class="navbar navbar-expand-lg navbar-dark bg-dark <?php if(!isset($title)){ echo "fixed-top"; } ?>">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">LSaver</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <?php if(isset($_SESSION['user'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="profile.php?user=<?php echo $_SESSION['user']; ?>">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        <?php endif; ?>
        <?php if(!isset($_SESSION['user'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="signup.php">Sign up</a>
            </li>
        <?php endif; ?>
      </ul>
      <form class="d-flex" method="GET" action="profile.php">
        <input class="form-control me-2" type="search" placeholder="Search a user" aria-label="Search" name="user">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>