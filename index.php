<!DOCTYPE html>
<html lang='en'>
<head>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta charset='UTF-8'>
    <title>Shop</title>
    <script>
        function changeForm() {
            var clients = document.getElementById('clients');
            var products = document.getElementById('products');
            if (clients && products) {
                if (clients.style.display === 'none') {
                    clients.style.display = 'block';
                    products.style.display = 'none';
                }
                else {
                    clients.style.display = 'none';
                    products.style.display = 'block';
                }
            }
        }
    </script>
</head>
<body>

<div class="add" id="clients">
    Add client:
    <form name="clients" method="POST">
        <label> Name <br>
            <input type="text" name="name"><br>
        </label>
        <label> Age <br>
            <input type="number" name="age"><br>
        </label>
        <label> Purchase price <br>
            <input type="number" name="purchase_price"><br>
        </label>

        <input name="submit" type="submit">

        <input type="hidden" name="state" value="add">
    </form>
</div>

<div class="add" id="products">
    Add product:
    <form name="products" method="POST">
        <label> Name <br>
            <input type="text" name="name"><br>
        </label>
        <label> Type <br>
            <input type="number" name="age"><br>
        </label>
        <label> Description <br>
            <input type="number" name="purchase_price"><br>
        </label>

        <input name="submit" type="submit">

        <input type="hidden" name="state" value="add">
    </form>
</div>

<div class="show">
    <form name="clients" method="POST">
        <input name="show" type="submit" value="Show clients">

        <input type="hidden" name="state" value="show">
    </form>
</div>
<div>
    <button onclick="changeForm()">dupa</button>
</div>

<?php
$connection = new mysqli('localhost', 'root', '', 'shop');

if ($connection->connect_error) {
    echo "Error connecting to database";
    die("Connection failed: " . $connection->connect_error);
}

if ($_POST["state"] == "add") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $purchase_price = $_POST["purchase_price"];

    $sql = "INSERT INTO clients (name, age, purchase_price)
    VALUES ('" . $name . "','" . $age . "','" . $purchase_price . "')";

    if (mysqli_query($connection, $sql)) {
        echo "Added new client";
    }
}

if ($_POST["state"] == "show") {
    $sql = "SELECT * FROM clients";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        echo "<div class='clients_display'>
    <table>
        <tr>
            <td>id</td>
            <td>name</td>
            <td>age</td>
            <td>purchase price</td>
        </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["clientID"] . "</td>"
                . "<td>" . $row["name"] . "</td>"
                . "<td>" . $row["age"] . "</td>"
                . "<td>" . $row["purchase_price"] . "</td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "No elements in table";
    }
}

$connection->close();
?>

</body>
</html>