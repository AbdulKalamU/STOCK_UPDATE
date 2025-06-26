<?php
// 1. Connect to database
$conn = new mysqli("localhost", "root", "", "stock_dashboard");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Stock Dashboard</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            padding: 30px;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: auto;
            background-color: white;
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #222;
            color: white;
        }
        .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .in-stock { background: #c8e6c9; color: green; }
        .low-stock { background: #fff3cd; color: #856404; }
        .out-stock { background: #f8d7da; color: red; }
    </style>
</head>
<body>

<h2 style="text-align:center;">📦 Product Stock Status Dashboard</h2>

<table>
    <tr>
        <th>Product Name</th>
        <th>Stock Quantity</th>
        <th>Status</th>
    </tr>

    <?php
    // 3. Loop through products and display
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $quantity = $row['quantity'];
            $status = "";
            $class = "";

            if ($quantity > 10) {
                $status = "In Stock";
                $class = "in-stock";
            } elseif ($quantity > 0) {
                $status = "Low Stock";
                $class = "low-stock";
            } else {
                $status = "Out of Stock";
                $class = "out-stock";
            }

            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['quantity']}</td>
                    <td><span class='status $class'>$status</span></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No products found</td></tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>
