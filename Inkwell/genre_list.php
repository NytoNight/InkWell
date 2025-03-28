<?php
	session_start();
	require_once "./functions/database_functions.php";
	$conn = db_connect();

	$query = "SELECT * FROM publisher ORDER BY publisherid";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}
	if(mysqli_num_rows($result) == 0){
		echo "Empty publisher ! Something wrong! check again";
		exit;
	}

	$title = "List Of Publishers";
	require "./template/header.php";
?>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

	body {
		font-family: 'Lucida Handwriting', cursive; 
		background-color: #f1dbdd; 
		color: #333;
	}

	.h5.fw-bolder.text-center {
		color: #2c3e50;
		margin-bottom: 20px;
		font-weight: 700;
		font-size: 2rem; 
	}

	.genre-container {
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		gap: 20px;
		margin-top: 20px;
	}

	.genre-card {
		background: #fff;
		border: 1px solid #ddd;
		border-radius: 8px;
		width: 250px;
		box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
		overflow: hidden;
		text-align: center;
		transition: transform 0.3s ease, box-shadow 0.3s ease; 
	}

	.genre-card:hover {
		transform: scale(1.05); 
		box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2); 
	}

	.genre-card img {
		width: 100%;
		height: 150px;
		object-fit: cover;
	}

	.genre-card .genre-info {
		padding: 15px;
	}

	.genre-card .genre-info h5 {
		margin: 10px 0;
		font-size: 1.5rem; 
		color: #007bff;
		text-decoration: none; 
	}

	.genre-card .genre-info h5 a {
		text-decoration: none; 
	}

	.genre-card .genre-info h5 a:hover {
		text-decoration: none; 
		color: #0056b3; 
	}

	.genre-card .genre-info p {
		margin: 0;
		font-size: 1.2rem; 
		color: #555;
	}
</style>
	<div class="h5 fw-bolder text-center">Genres</div>
	<hr>
	<div class="genre-container">
	<?php 
		while($row = mysqli_fetch_assoc($result)){
			$count = 0; 
			$query = "SELECT publisherid FROM books";
			$result2 = mysqli_query($conn, $query);
			if(!$result2){
				echo "Can't retrieve data " . mysqli_error($conn);
				exit;
			}
			while ($pubInBook = mysqli_fetch_assoc($result2)){
				if($pubInBook['publisherid'] == $row['publisherid']){
					$count++;
				}
			}
	?>
		<div class="genre-card">
			<a href="bookPerPub.php?pubid=<?php echo $row['publisherid']; ?>">
				<img src="genre_images/<?php echo $row['publisherid']; ?>.png" alt="<?php echo $row['publisher_name']; ?>">
			</a>
			<div class="genre-info">
				<h5>
					<a href="bookPerPub.php?pubid=<?php echo $row['publisherid']; ?>">
						<?php echo $row['publisher_name']; ?>
					</a>
				</h5>
				<p><?php echo $count; ?> Books</p>
			</div>
		</div>
	<?php } ?>
	</div>
<?php
	mysqli_close($conn);
	require "./template/footer.php";
?>