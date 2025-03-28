<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap/css/styles.css" rel="stylesheet">
    <link href="./bootstrap/css/animations.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="./bootstrap/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="./bootstrap/js/bootstrap.bundle.min.js"></script>

    <style>
      .nav-link {
        font-size: 1.25rem; 
        margin-right: 15px; 
      }
      body {
        animation: fadeIn 1s ease-in-out;
      }
    </style>
  </head>

  <body style="background-image: url('cloud.jpg'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
    <div class="clear-fix pt-5 pb-3"></div>
    <nav class="navbar navbar-expand-lg navbar-expand-md navbar-light fixed-top" style="background-color: #f1dbdd; font-family: 'Lucida Handwriting', cursive;">
      <div class="container">
        <div class="navbar-header">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav" aria-controls="topNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
          <a class="navbar-brand" href="index.php" style="font-family: 'Lucida Handwriting', cursive; font-size: 2rem; color: #000;">InkWell</a>
        </div>
        <div class="collapse navbar-collapse" id="topNav">
          <ul class="nav navbar-nav ms-auto">
            <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == true): ?>
                <li class="nav-item"><a class="nav-link" href="admin_book.php"><span class="fa fa-th-list"></span> Book List</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_add.php"><span class="far fa-plus-square"></span> Add New Book</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_orders.php"><span class="fa fa-box"></span> Admin Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_signout.php"><span class="fa fa-sign-out-alt"></span> Logout</a></li>
            <?php else: ?>
              <li class="nav-item"><a class="nav-link" href="genre_list.php"><span class="fa fa-paperclip"></span> Genres</a></li>
              <li class="nav-item"><a class="nav-link" href="books.php"><span class="fa fa-book"></span> Books</a></li>
              <li class="nav-item"><a class="nav-link" href="cart.php"><span class="fa fa-shopping-cart"></span> My Cart</a></li>
              <?php if (isset($_SESSION['user'])): ?>
                  <li class="nav-item"><a class="nav-link" href="logout.php"><span class="fa fa-sign-out-alt"></span> Logout</a></li>
              <?php else: ?>
                  <li class="nav-item"><a class="nav-link" href="login.php"><span class="fa fa-sign-in-alt"></span> Login</a></li>
              <?php endif; ?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
    <?php
      if(isset($title) && $title == "Home") {
    ?>
      <div class="container text-center">
        <h1 style="font-family: 'Lucida Handwriting', cursive;">Inkwell Bookstore</h1>
        <hr>
      </div>
    <?php } ?>

    <div class="container" id="main">