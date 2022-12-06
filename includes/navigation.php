<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo $home_url; ?>"><?php echo $title; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo $home_url; ?>">Home</a>
        </li>
        <!-- Login, Register Page if loggedin -->
        <?php if ($is_loggedin == false) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $home_url; ?>account/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $home_url; ?>account/register.php">Register</a>
          </li>
        <?php else : ?>
          <!-- Logout Page if loggedin -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $home_url; ?>account/logout.php">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>