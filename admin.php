<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
// DB Connection
$conn = new mysqli("localhost", "root", "", "stock_dashboard");

// Handle update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    
    $sql = "UPDATE products SET quantity = $quantity WHERE id = $id";
    $conn->query($sql);
    header("Location: admin.php"); // Refresh after update
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Update Stock</title>
    <style>
        body { font-family: Arial; padding: 30px; background: #f9f9f9; }
        table { width: 80%; border-collapse: collapse; margin: auto; background: white; }
        th, td { padding: 15px; text-align: center; border: 1px solid #ccc; }
        th { background: #222; color: white; }
        form { display: flex; justify-content: center; align-items: center; gap: 10px; }
        input[type=number] { width: 80px; padding: 5px; }
        input[type=submit] { padding: 5px 10px; cursor: pointer; background: #222; color: white; border: none; }
    </style>
    <p style="text-align:center;">
    <a href="logout.php" style="color: red;">Logout</a>
</p>
</head>
<body>


<h2 style="text-align:center;">🛠 Admin Panel - Update Product Stock</h2>

<table>
    <tr>
        <th>Product Name</th>
        <th>Current Stock</th>
        <th>Update</th>
    </tr>

    <?php
    $result = $conn->query("SELECT * FROM products");
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['quantity']}</td>
            <td>
                <form method='POST'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <input type='number' name='quantity' value='{$row['quantity']}' min='0'>
                    <input type='submit' name='update' value='Update'>
                </form>
            </td>
        </tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>
