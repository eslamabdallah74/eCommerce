<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="dashbored.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php">Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="items.php">Items</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php?action=manage">Members</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comments.php">Comments</a>
        </li>

      </ul>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Eslam</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li> <a class="dropdown-item"  href="../index.php" target="_blank"> Visit Shop </a></li>
          <li><a class="dropdown-item" href="members.php?action=edit&userid=<?php
          echo $_SESSION['ID'];?>">Edit Profile</a></li>
          <li> <a class="dropdown-item" href="#">Settings</a></li>
          <li> <a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
      </li>
    </div>
  </div>
</nav>
