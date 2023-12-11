<?php
require './config/Database.php';
require('./classes/Product.php');
require './classes/DVD.php';
require('./classes/Book.php');
require './classes/Furniture.php';

$stmt = $pdo->query('SELECT * FROM products');
$products = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    switch ($row['productType']) {
        case 'DVD':
            $products[] = new DVD($row['sku'], $row['product_name'], $row['product_price'], $row['size_mb']);
            break;
        case 'Book':
            $products[] = new Book($row['sku'], $row['product_name'], $row['product_price'], $row['book_weight']);
            break;
        case 'Furniture':
            $products[] = new Furniture($row['sku'], $row['product_name'], $row['product_price'], $row['furniture_height'], $row['furniture_width'], $row['furniture_length']);
            break;
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "deleteProducts") {
    if (!empty($_POST["products"])) {
        $skusToDelete = $_POST["products"];
        $success = true;

        foreach ($skusToDelete as $sku) {
            $productToDelete = null;

            foreach ($products as $key => $product) {
                if ($product->getSku() === $sku) {
                    $productToDelete = $product;
                    break;
                }
            }

            if ($productToDelete !== null) {
                if (!$productToDelete->delete($pdo)) {
                    $success = false;
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['status' => $success ? 'success' : 'error']);
        exit();
    }
}




?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-4 offset-md-2">
                <h2>Product List</h2>
            </div>
            <form action="" method="POST" class="col-md-4 offset-md-2 text-right" id="delete-form">
                <input type="hidden" name="action" value="deleteProducts">
                <a href="Product/addproduct.php" class="btn btn-primary mx-3">ADD</a>
                <?php foreach ($products as $product) : ?>
                    <input type="hidden" name="products[]" value="<?php echo $product->getSku(); ?>">
                <?php endforeach; ?>
                <button class="btn btn-danger delete-product-btn" name="delete_skus">MASS Delete</button>
            </form>

        </div>
        <div class="row">
            <div class="col-md-12 line"></div>
        </div>
    </div>


    <div class="container mt-4">
        <div class="row">
            <?php
            foreach ($products as $product) {
                echo '<div class="col-lg-3 m-5">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<div class="form-group">';
                echo '<div class="custom-control">';
                echo '<input type="checkbox" class="custom-control-input delete-checkbox" data-sku="' . $product->getSku() . '">';
                echo '</div>';
                echo '</div>';
                echo '<div class="text-center">';
                echo '<div class="product-card">';

                switch (get_class($product)) {
                    case 'DVD':
                        echo '<h3>DVD Details</h3>';
                        echo '<p>SKU: ' . $product->getSku() . '</p>';
                        echo '<p>Name: ' . $product->getProductName() . '</p>';
                        echo '<p>Price: ' . $product->getProductPrice() . '$' . '</p>';
                        echo '<p>Size ' . $product->getSizeMB() . 'MB' . '</p>';
                        break;

                    case 'Book':
                        echo '<h3>Book Details</h3>';
                        echo '<p>SKU: ' . $product->getSku() . '</p>';
                        echo '<p>Name: ' . $product->getProductName() . '</p>';
                        echo '<p>Price: ' . $product->getProductPrice() . '$' . '</p>';
                        echo '<p>Weight: ' . $product->getWeight() . 'KG' . '</p>';
                        break;

                    case 'Furniture':
                        echo '<h3>Furniture Details</h3>';
                        echo '<p>SKU: ' . $product->getSku() . '</p>';
                        echo '<p>Name: ' . $product->getProductName() . '</p>';
                        echo '<p>Price: ' . $product->getProductPrice() . '$' . '</p>';
                        echo 'Dimensions: ' . $product->getHeight() . 'x' . $product->getWidth() . 'x' . $product->getLength();
                        break;
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
     $(document).ready(function() {
    $(".delete-product-btn").on("click", function(e) {
        e.preventDefault();

        var selectedProducts = $(".delete-checkbox:checked");
        var skusToDelete = selectedProducts.map(function() {
            return $(this).data("sku");
        }).get();

        if (skusToDelete.length === 0) {
            return;
        }

        $.ajax({
            url: window.location.href,
            method: "POST",
            data: {
                action: "deleteProducts",
                products: skusToDelete
            },
            dataType: "json",
            success: function(response) {
                console.log(response);

                if (response.status === "success") {
                    // Reload the page after a successful AJAX request
                    window.location.reload();
                } else {
                    console.log("Unexpected response:", response);
                }
            },
            error: function() {
                console.log("Error in AJAX request");
            }
        });
    });
});
    </script>
</body>

</html>