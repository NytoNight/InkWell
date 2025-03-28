<?php
  session_start();
  $count = 0;
  // connecto database
  require_once "./functions/database_functions.php";
  $conn = db_connect();

  $query = "SELECT book_isbn, book_image, book_title FROM books";
  $result = mysqli_query($conn, $query);
  if(!$result){
    echo "Can't retrieve data " . mysqli_error($conn);
    exit;
  }

  $title = "List of Books";
  require_once "./template/header.php";
?>
  <p class="lead text-center text-muted" style="font-family: 'Lucida Handwriting', cursive; font-size: 1.5rem; font-weight: bold; color: black;">List of All Books</p>
    <?php for($i = 0; $i < mysqli_num_rows($result); $i++){ ?>
      <div class="row">
        <?php while($book = mysqli_fetch_assoc($result)){ ?>
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 py-2 mb-2">
      		<a href="book.php?bookisbn=<?php echo $book['book_isbn']; ?>" class="card rounded-0 shadow book-item text-reset text-decoration-none border">
            <div class="img-holder overflow-hidden rounded-top" style="height: 250px;">
              <img class="img-top w-100 h-100 object-fit-cover" src="./bootstrap/img/<?php echo $book['book_image']; ?>">
            </div>
            <div class="card-body bg-light">
              <div class="card-title fw-bold h5 text-center text-primary"><?= $book['book_title'] ?></div>
            </div>
          </a>
      	</div>
        <?php
          $count++;
          if($count >= 4){
              $count = 0;
              break;
            }
          } ?> 
      </div>
<?php
      }
  if(isset($conn)) { mysqli_close($conn); }
  require_once "./template/footer.php";
?>