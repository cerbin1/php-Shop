<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'client') {
        http_response_code(201);
    }

    if ($_POST['action'] == 'product') {
        http_response_code(201);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] == 'clients') {
        echo json_encode([
            'clients' => [
                ['name' => 'stefek', 'id' => 1, 'age' => 12, 'purchase_price' => 152],
                ['name' => 'rafal', 'id' => 2, 'age' => 12, 'purchase_price' => 152],
                ['name' => 'marcin', 'id' => 3, 'age' => 12, 'purchase_price' => 152]
            ]
        ]);
    }

    if ($_GET['action'] == 'products') {
        echo json_encode([
            'products' => [
                ['name' => 'banan', 'id' => 1, 'type' => 'electronic', 'price' => 152],
                ['name' => 'banan', 'id' => 2, 'type' => 'electronic', 'price' => 152],
                ['name' => 'banan', 'id' => 3, 'type' => 'electronic', 'price' => 152]
            ]
        ]);
    }
}
