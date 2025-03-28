<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header('location:admin.php');
    exit;
}

require_once "./functions/database_functions.php";
$conn = db_connect();

$title = "Manage Orders";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $orderid = $_POST['orderid'];
        $query = "DELETE FROM orders WHERE orderid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $orderid);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $orderid = $_POST['orderid'];
        $amount = $_POST['amount'];
        $ship_name = $_POST['ship_name'];
        $ship_address = $_POST['ship_address'];
        $ship_city = $_POST['ship_city'];
        $ship_zip_code = $_POST['ship_zip_code'];
        $ship_country = $_POST['ship_country'];

        $query = "UPDATE orders SET amount = ?, ship_name = ?, ship_address = ?, ship_city = ?, ship_zip_code = ?, ship_country = ? WHERE orderid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("dsssssi", $amount, $ship_name, $ship_address, $ship_city, $ship_zip_code, $ship_country, $orderid);
        $stmt->execute();
    }
}

$query = "SELECT * FROM orders";
$result = mysqli_query($conn, $query);
?>

<?php require_once "./template/header.php"; ?>
<style>
/* Copied CSS from admin_book.php */
.card {
    border: none;
    border-radius: 0;
}

.card-body {
    background-color: #f1dbdd;
}

.table thead {
    background-color: #dbf1ef;
}

.table .text-truncate {
    width: 15em;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

hr.bg-warning {
    width: 5em;
    height: 3px;
    opacity: 1;
}
</style>
<div class="container my-5">
    <h4 class="fw-bolder text-center">Manage Orders</h4>
    <center>
        <hr class="bg-warning">
    </center>
    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer ID</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Ship Name</th>
                            <th>Ship Address</th>
                            <th>Ship City</th>
                            <th>Ship Zip Code</th>
                            <th>Ship Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <form method="post">
                                    <td><?= $row['orderid'] ?></td>
                                    <td><?= $row['customerid'] ?></td>
                                    <td>
                                        <input type="number" step="0.01" name="amount" value="<?= $row['amount'] ?>" class="form-control form-control-sm">
                                    </td>
                                    <td><?= $row['date'] ?></td>
                                    <td>
                                        <input type="text" name="ship_name" value="<?= $row['ship_name'] ?>" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="ship_address" value="<?= $row['ship_address'] ?>" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="ship_city" value="<?= $row['ship_city'] ?>" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="ship_zip_code" value="<?= $row['ship_zip_code'] ?>" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="ship_country" value="<?= $row['ship_country'] ?>" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="hidden" name="orderid" value="<?= $row['orderid'] ?>">
                                        <button type="submit" name="update" class="btn btn-sm btn-success">Update</button>
                                        <button type="submit" name="delete" class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </form>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
mysqli_close($conn);
require_once "./template/footer.php";
?>
