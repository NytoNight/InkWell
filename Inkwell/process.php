<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$_SESSION['err'] = 1;
foreach($_POST as $key => $value){
    if(trim($value) == ''){
        $_SESSION['err'] = 0;
    }
    break;
}

if($_SESSION['err'] == 0){
    header("Location: purchase.php");
} else {
    unset($_SESSION['err']);
}

require_once "./functions/database_functions.php";
$title = "Purchase Process";
require "./template/header.php";
// connect database
$conn = db_connect();
extract($_SESSION['ship']);

// validate post section
$card_number = $_POST['card_number'];
$card_PID = $_POST['card_PID'];
$card_expire = strtotime($_POST['card_expire']);
$card_owner = $_POST['card_owner'];

// Get the logged-in user's ID and address details
$userid = $_SESSION['user']['id'];
$name = $_SESSION['user']['name'];
$address = $_SESSION['user']['address'];
$city = $_SESSION['user']['city'];
$zip_code = $_SESSION['user']['zip_code'];
$country = $_SESSION['user']['country'];

// Find or create the user in the `users` table
$customerid = getCustomerId($name, $address, $city, $zip_code, $country);
if ($customerid == null) {
    $customerid = setCustomerId($name, $address, $city, $zip_code, $country);
}

// Insert the order into the database
$date = date("Y-m-d H:i:s");
$query = "INSERT INTO orders (userid, amount, date, ship_name, ship_address, ship_city, ship_zip_code, ship_country) 
          VALUES ('$customerid', '{$_SESSION['total_price']}', '$date', '$name', '$address', '$city', '$zip_code', '$country')";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo "Insert order failed: " . mysqli_error($conn);
    exit;
}

// Get the order ID of the newly created order
$orderid = getOrderId($conn, $customerid);

// Insert order items into the database
foreach($_SESSION['cart'] as $isbn => $qty){
    $bookprice = getbookprice($isbn);
    $query = "INSERT INTO order_items (orderid, book_isbn, item_price, quantity) 
              VALUES ('$orderid', '$isbn', '$bookprice', '$qty')";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Insert order items failed: " . mysqli_error($conn);
        exit;
    }
}

session_unset();
?>
    <div class="alert alert-success rounded-0 my-4">Your order has been processed successfully. We'll be reaching out to confirm your order. Thanks!</div>
<?php
if(isset($conn)){
    mysqli_close($conn);
}
require_once "./template/footer.php";
?>