<!DOCTYPE html>
<html lang='en'>
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css">
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

<div class="col-sm-4" id="clients">
    Add client:
    <form name="clients" method="POST">
        <label> Name <br>
            <input class="form-control" type="text" name="name">
        </label>
        <label> Age <br>
            <input class="form-control" type="number" name="age">
        </label>
        <label> Purchase price <br>
            <input class="form-control" type="number" name="purchase_price">
        </label>

        <input class="btn btn-primary" type="submit" value="Add client">
        <input type="hidden" name="state" value="add_client">
    </form>
</div>

<div class="col-sm-4" id="products">
    Add product:
    <form name="products" method="POST">
        <label> Name <br>
            <input class="form-control" type="text" name="name">
        </label>
        <label> Type <br>
            <input class="form-control" type="text" name="type">
        </label>
        <label> Price <br>
            <input class="form-control" type="number" name="price">
        </label>

        <input class="btn btn-primary" type="submit" value="Add product">
        <input type="hidden" name="state" value="add_product">
    </form>
</div>

<div class="buttons col-sm-2">
    <form name="clients" method="POST">
        <input class="btn" type="submit" value="Show clients">

        <input type="hidden" name="state" value="show_clients">
    </form>

    <form name="clients" method="POST">
        <input class="btn" type="submit" value="Show products">

        <input type="hidden" name="state" value="show_products">
    </form>

    <button class="btn" onclick="changeForm()">Switch to add client/product</button>
</div>

<?php
$mysqli = new mysqli('localhost', 'root', '', 'shop');

if ($mysqli->connect_error) {
    echo "Error connecting to database";
    die("Connection failed: " . $mysqli->connect_error);
}

function isAddClientClicked()
{
    return isset($_POST) && array_key_exists('state', $_POST) && $_POST['state'] == 'add_client';
}

if (isAddClientClicked()) {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $purchase_price = $_POST["purchase_price"];

    $name = $mysqli->real_escape_string($name);
    $age = $mysqli->real_escape_string($age);
    $purchase_price = $mysqli->real_escape_string($purchase_price);

    $sql = "INSERT INTO clients (name, age, purchase_price)
    VALUES ('" . $name . "','" . $age . "','" . $purchase_price . "')";

    if (mysqli_query($mysqli, $sql)) {
        echo "Added new client";
    }
}

function isAddProductClicked()
{
    return isset($_POST) && array_key_exists('state', $_POST) && $_POST['state'] == 'add_product';
}

if (isAddProductClicked()) {
    $name = $_POST["name"];
    $type = $_POST["type"];
    $price = $_POST["price"];

    $name = $mysqli->real_escape_string($name);
    $type = $mysqli->real_escape_string($type);
    $price = $mysqli->real_escape_string($price);

    $sql = "INSERT INTO products (name, type, price)
    VALUES ('" . $name . "','" . $type . "','" . $price . "')";

    if (mysqli_query($mysqli, $sql)) {
        echo "Added new product";
    }
}

function isShowClientsClicked()
{
    return isset($_POST) && array_key_exists('state', $_POST) && $_POST['state'] == 'show_clients';
}

if (isShowClientsClicked()) {
    $sql = "SELECT * FROM clients";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        echo "<div class='col-md-6 clients_display'>
    <table class='table table-hover'>
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

function isShowProductsClicked()
{
    return isset($_POST) && array_key_exists('state', $_POST) && $_POST['state'] == 'show_products';
}

if (isShowProductsClicked()) {
    $sql = "SELECT * FROM products";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        echo "<div class='col-md-6 clients_display'>
    <table class='table table-hover'>
        <tr>
            <td>id</td>
            <td>name</td>
            <td>type</td>
            <td>price</td>
        </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["productID"] . "</td>"
                . "<td>" . $row["name"] . "</td>"
                . "<td>" . $row["type"] . "</td>"
                . "<td>" . $row["price"] . "</td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "No elements in table";
    }
}

$mysqli->close();
?>

</body>
</html>