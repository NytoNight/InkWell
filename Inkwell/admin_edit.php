<?php
	session_start();
	require_once "./functions/admin.php";
	$title = "Edit book";
	require_once "./template/header.php";
	require_once "./functions/database_functions.php";
	$conn = db_connect();

	if(isset($_GET['bookisbn'])){
		$book_isbn = $_GET['bookisbn'];
	} else {
		echo "Empty query!";
		exit;
	}

	if(!isset($book_isbn)){
		echo "Empty isbn! check again!";
		exit;
	}
	// get book data
	$query = "SELECT * FROM books WHERE book_isbn = '{$book_isbn}'";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo $err = "Can't retrieve data ";
		exit;
	}else{
		$row = mysqli_fetch_assoc($result);
	}
	if(isset($_POST['edit'])){
		$isbn = trim($_POST['isbn']);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, ['edit', 'isbn'])){
				if(!empty($data)) $data .=", ";
				$data .= "`{$k}` = '".(mysqli_real_escape_string($conn, $v))."'";
			}
		}


		$query = "UPDATE books set $data where book_isbn = '{$book_isbn}'";
		$result = mysqli_query($conn, $query);
		if($result){
			$_SESSION['book_success'] = "Book Details has been updated successfully";
			header("Location: admin_book.php");
		} else {
			$err =  "Can't update data " . mysqli_error($conn);
		}
	}
?>
	<style>
		.card {
			border: 1px solid #ddd;
			background-color: #f9f9f9;
			animation: popUp 0.5s ease-in-out;
		}
		.card-body {
			padding: 20px;
		}
		.form-control, .form-select {
			border: 1px solid #ccc;
			box-shadow: none;
			transition: border-color 0.3s ease-in-out;
		}
		.form-control:focus, .form-select:focus {
			border-color: #007bff;
			box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
		}
		.btn-primary {
			background-color: #007bff;
			border-color: #007bff;
			transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out;
		}
		.btn-primary:hover {
			background-color: #0056b3;
			border-color: #004085;
		}
		.btn-default {
			color: #333;
			background-color: #fff;
			border-color: #ccc;
		}
		.btn-default:hover {
			color: #000;
			background-color: #e6e6e6;
			border-color: #adadad;
		}
		.text-center button {
			margin: 5px;
		}
		.alert {
			margin-bottom: 20px;
		}
		@keyframes popUp {
			0% {
				transform: scale(0.8);
				opacity: 0;
			}
			100% {
				transform: scale(1);
				opacity: 1;
			}
		}
	</style>
	<h4 class="fw-bolder text-center">Edit Book Details</h4>
	<center>
	<hr class="bg-warning" style="width:5em;height:3px;opacity:1">
	</center>
	<div class="row justify-content-center">
		<div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
			<div class="card rounded-0 shadow">
				<div class="card-body">
					<div class="container-fluid">
						<?php if(isset($err)): ?>
							<div class="alert alert-danger rounded-0">
								<?= $_SESSION['err_login'] ?>
							</div>
						<?php 
							endif;
						?>
						<form method="post" action="admin_edit.php?bookisbn=<?php echo $row['book_isbn'];?>" enctype="multipart/form-data">
								<div class="mb-3">
									<label class="control-label">ISBN</label>
									<input class="form-control rounded-0" type="text" name="isbn" value="<?php echo $row['book_isbn'];?>" readOnly="true">
								</div>
								<div class="mb-3">
									<label class="control-label">Title</label>
									<input class="form-control rounded-0" type="text" name="book_title" value="<?php echo $row['book_title'];?>" required>
								</div>
								<div class="mb-3">
									<label class="control-label">Author</label>
									<input class="form-control rounded-0" type="text" name="book_author" value="<?php echo $row['book_author'];?>" required>
								</div>
								<div class="mb-3">
									<label class="control-label">Description</label>
									<textarea class="form-control rounded-0" name="book_descr" cols="40" rows="5"><?php echo $row['book_descr'];?></textarea>
								</div>
								<div class="mb-3">
									<label class="control-label">Price</label>
									<input class="form-control rounded-0" type="text" name="book_price" value="<?php echo $row['book_price'];?>" required>
								</div>
								<div class="mb-3">
									<label class="control-label">Genre</label>
									<select class="form-select rounded-0"  name="publisherid" required>
										<?php 
										$psql = mysqli_query($conn, "SELECT * FROM `publisher` order by publisher_name asc");
										while($row = mysqli_fetch_assoc($psql)):
										?>
										<option value="<?= $row['publisherid'] ?>" <?= $row['publisherid']==$row['publisherid'] ? 'selected' : '' ?>><?= $row['publisher_name'] ?></option>
										<?php endwhile; ?>
									</select>

								</div>
								<div class="text-center">
									<button type="button" class="btn btn-default btn-sm rounded-0 border" onclick="window.location.href='admin_book.php';">Cancel</button>
									<button type="submit" name="edit" class="btn btn-primary btn-sm rounded-0">Update</button>
								</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	if(isset($conn)) {mysqli_close($conn);}
	require "./template/footer.php"
?>