<?php

include('./config/Database.php');
include_once('./classes/Product.php');



class Book extends Product
{
    protected $weight;

    public function __construct($sku, $productName, $productPrice, $weight) {
        parent::__construct($sku, $productName, $productPrice);
        $this->weight = $weight;
        $this->productType = 'Book';
    }

    // Getter and setter methods for book-specific property

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function save(PDO $pdo) {
        // Check SKU uniqueness before saving
        if (!$this->isSkuUnique($pdo)) {
            echo "SKU already exists. Please choose a different SKU.";
            // Add a die statement to stop execution for debugging
            die;
        }

        // Continue with the save process
        $stmt = $pdo->prepare("INSERT INTO products (sku, product_name, product_price, book_weight, productType) VALUES (:sku, :product_name, :product_price, :book_weight, :productType)");
        $stmt->execute([
            ':sku' => $this->sku,
            ':product_name' => $this->productName,
            ':product_price' => $this->productPrice,
            ':book_weight' => $this->weight,
            ':productType' => $this->productType,
        ]);

        echo "Product saved successfully!";
    }


    public function displayDetails(PDO $pdo)
    {
        try {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE sku = :sku AND productType = 'Book'");
            $stmt->execute([':sku' => $this->sku]);
            $bookData = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "<h2>Book Product Details</h2>";
            echo "SKU: {$bookData['sku']}, Name: {$bookData['product_name']}, Price: {$bookData['product_price']}, Weight (Kg): {$bookData['book_weight']}";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }




    public function delete($pdo)
    {
        try {
            parent::delete($pdo);
            return true;    
        } catch (Exception $e) {
            // Log the error message
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }
}
