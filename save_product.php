<?php
include ('./config/Database.php');
include 'classes/Book.php';
include 'classes/DVD.php';
include 'classes/Furniture.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sku = $_POST['sku'];
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $productType = $_POST['productType'];
    $product = null;  

    switch ($productType) {
        case 'DVD':
            $sizeMB = $_POST['size_mb'];
            $product = new DVD($sku, $name, $price, $sizeMB);
            break;
        case 'Book':
            $weight = $_POST['book_weight'];
            $product = new Book($sku, $name, $price, $weight);
            break;
        case 'Furniture':
            $height = $_POST['furniture_height'];
            $width = $_POST['furniture_width'];
            $length = $_POST['furniture_length'];
            $product = new Furniture($sku, $name, $price, $height, $width, $length);
            break;
        default:
            // Handle invalid product type
            break;
    }


    if ($product !== null) {
        // Debugging: Print the product information
        // echo "Product details: ";
        // print_r($product);

        // Save the product only if it's not null
        $product->save($pdo);
        // echo "Product saved successfully!";
        header("location:index.php");
    } else {
        echo "Invalid product type!";
    }
}
?>
