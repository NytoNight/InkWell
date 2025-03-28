<?php
session_start();
$count = 0;

$title = "Home";
require_once "./template/header.php";
require_once "./functions/database_functions.php";
$conn = db_connect();
$row = selectLatestBooks($conn, 12); // Fetch 12 latest books
?>
      <!-- Introductory Section -->
      <div class="container my-5 p-4 rounded shadow" style="background-color: #f1dbdd; border: 1px solid #ddd;">
        <h2 class="text-center fw-bold" style="color: #4a4a4a;">Welcome to Inkwell Bookstore</h2>
        <p class="mt-3 text-center" style="color: #6c757d; font-size: 1.1rem;">
          Welcome to our online bookstore, your gateway to a world of knowledge, imagination, and inspiration. 
          Whether you're looking for the latest bestsellers, timeless classics, or hidden gems, we have something for every reader. 
          Explore our carefully curated collection and embark on your next literary adventure today!
        </p>
      </div>

      <!-- Latest Books Section -->
      <div class="lead text-center text-dark fw-bolder h4" style="background-image: url('./bootstrap/img/cloud.jpg') !important; background-size: cover !important; background-position: center !important;">Latest books</div>
      <center>
        <hr class="bg-warning" style="width:5em;height:3px;opacity:1">
      </center>
      <div class="row">
        <?php foreach($row as $book) { ?>
      	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 py-2 mb-2">
      		<a href="book.php?bookisbn=<?php echo $book['book_isbn']; ?>" class="card rounded-0 shadow book-item text-reset text-decoration-none">
            <div class="img-holder overflow-hidden">
              <img class="img-top" src="./bootstrap/img/<?php echo $book['book_image']; ?>">
            </div>
            <div class="card-body">
              <div class="card-title fw-bolder h5 text-center"><?= $book['book_title'] ?></div>
            </div>
          </a>
      	</div>
        <?php } ?>
      </div>
<?php
if (isset($conn)) {
    mysqli_close($conn);
}
require_once "./template/footer.php";
?>