<nav class="navbar navbar-expand-lg bg-light navbar-light">
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
        <!-- Login, Register Page -->
        <?php if ($is_loggedin !== true) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $home_url; ?>account/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $home_url; ?>account/register.php">Register</a>
          </li>
        <?php else : ?>
          <!-- Bookings -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $home_url; ?>account/bookings.php">Bookings</a>
          </li>
          <!-- Listings -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $home_url; ?>account/my-listings.php">Listings</a>
          </li>
          <!-- Profile Page -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $home_url; ?>account/profile.php">Profile</a>
          </li>
          <!-- Logout Page -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $home_url; ?>account/logout.php">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
      <!-- List EV Charge Point Button -->
      <?php if ($is_loggedin == true) : ?>
        <a href="<?php echo $home_url; ?>EV-Charge/become-provider.php" class="text-dark">
          <button class="btn btn-warning">List EV Charge Point</button>
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>