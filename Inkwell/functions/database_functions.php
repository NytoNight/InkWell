<?php
	function db_connect(){
		$conn = mysqli_connect("localhost", "root", "", "obs_db");
		if(!$conn){
			echo "Can't connect database " . mysqli_connect_error($conn);
			exit;
		}
		return $conn;
	}

	function selectLatestBooks($conn, $limit) {
		$query = "SELECT book_isbn, book_image, book_title FROM books ORDER BY abs(unix_timestamp(`Release Date`)) DESC LIMIT " . intval($limit);
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Can't retrieve data " . mysqli_error($conn);
		    exit;
		}
		$books = [];
		while($row = mysqli_fetch_assoc($result)) {
		    $books[] = $row;
		}
		return $books;
	}

	function getBookByIsbn($conn, $isbn){
		$query = "SELECT book_title, book_author, book_price FROM books WHERE book_isbn = '$isbn'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
	}

	function getOrderId($conn, $userid){
		$query = "SELECT orderid FROM orders WHERE userid = '$userid'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Retrieve data failed! " . mysqli_error($conn);
			exit;
		}
		$row = mysqli_fetch_assoc($result);
		return $row['orderid'];
	}

	function insertIntoOrder($conn, $userid, $total_price, $date, $ship_name, $ship_address, $ship_city, $ship_zip_code, $ship_country){
	    // Check if the userid exists in the users table
	    $userCheckQuery = "SELECT id FROM users WHERE id = '$userid'";
	    $userCheckResult = mysqli_query($conn, $userCheckQuery);
	    if (mysqli_num_rows($userCheckResult) == 0) {
	        echo "Error: User ID $userid does not exist in the users table.";
	        exit;
	    }

	    // Insert the order
	    $query = "INSERT INTO orders (userid, amount, date, ship_name, ship_address, ship_city, ship_zip_code, ship_country) 
	              VALUES ('$userid', '$total_price', '$date', '$ship_name', '$ship_address', '$ship_city', '$ship_zip_code', '$ship_country')";
	    $result = mysqli_query($conn, $query);
	    if (!$result) {
	        echo "Insert orders failed " . mysqli_error($conn);
	        exit;
	    }
	}

	function getbookprice($isbn){
		$conn = db_connect();
		$query = "SELECT book_price FROM books WHERE book_isbn = '$isbn'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "get book price failed! " . mysqli_error($conn);
			exit;
		}
		$row = mysqli_fetch_assoc($result);
		return $row['book_price'];
	}

	function getCustomerId($name, $address, $city, $zip_code, $country) {
	    global $conn;
	    $query = "SELECT id FROM users WHERE name = ? AND address = ? AND city = ? AND zip_code = ? AND country = ?";
	    $stmt = $conn->prepare($query);
	    $stmt->bind_param("sssss", $name, $address, $city, $zip_code, $country);
	    $stmt->execute();
	    $result = $stmt->get_result();
	    if ($result->num_rows > 0) {
	        $row = $result->fetch_assoc();
	        return $row['id'];
	    }
	    return null;
	}

	function setCustomerId($name, $address, $city, $zip_code, $country) {
	    global $conn;
	    $query = "INSERT INTO users (name, address, city, zip_code, country) VALUES (?, ?, ?, ?, ?)";
	    $stmt = $conn->prepare($query);
	    $stmt->bind_param("sssss", $name, $address, $city, $zip_code, $country);
	    if ($stmt->execute()) {
	        return $conn->insert_id;
	    }
	    return null;
	}

	function getPubName($conn, $pubid){
		$query = "SELECT publisher_name FROM publisher WHERE publisherid = '$pubid'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		if(mysqli_num_rows($result) == 0){
			echo "Empty books ! Something wrong! check again";
			exit;
		}

		$row = mysqli_fetch_assoc($result);
		return $row['publisher_name'];
	}

	function getAll($conn){
		$query = "SELECT * from books ORDER BY book_isbn DESC";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
	}
?>