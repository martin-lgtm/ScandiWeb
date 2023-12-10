<?php

include('./config/Database.php');


class DVD extends Product {
    protected $sizeMB;

    public function __construct($sku, $productName, $productPrice, $sizeMB) {
        parent::__construct($sku, $productName, $productPrice);
        $this->sizeMB = $sizeMB;
        $this->productType = 'DVD';
    }


    public function getSizeMB() {
        return $this->sizeMB;
    }

    public function setSizeMB($sizeMB) {
        $this->sizeMB = $sizeMB;
    }

    public function save(PDO $pdo) {
        // Check SKU uniqueness before saving
        if (!$this->isSkuUnique($pdo)) {
            echo "SKU already exists. Please choose a different SKU.";
            // Add a die statement to stop execution for debugging
            die;
        }

        // Continue with the save process
        $stmt = $pdo->prepare("INSERT INTO products (sku, product_name, product_price, size_mb, productType) VALUES (:sku, :product_name, :product_price, :size_mb, :productType)");
        $stmt->execute([
            ':sku' => $this->sku,
            ':product_name' => $this->productName,
            ':product_price' => $this->productPrice,
            ':size_mb' => $this->sizeMB,
            ':productType' => $this->productType,
        ]);

        echo "Product saved successfully!";
    }
    

    public function displayDetails(PDO $pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE sku = :sku AND productType = 'DVD'");
            $stmt->execute([':sku' => $this->sku]);
            $dvdData = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "<h2>DVD Product Details</h2>";
            echo "SKU: {$dvdData['sku']}, Name: {$dvdData['product_name']}, Price: {$dvdData['product_price']}, Size (MB): {$dvdData['size_mb']}";
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

?>
