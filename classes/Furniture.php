<?php

include('./config/Database.php');


class Furniture extends Product {
    protected $height;
    protected $width;
    protected $length;

    public function __construct($sku, $productName, $productPrice, $height, $width, $length) {
        parent::__construct($sku, $productName, $productPrice);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
        $this->productType = 'Furniture';
    }


    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function save(PDO $pdo) {
        if (!$this->isSkuUnique($pdo)) {
            echo "SKU already exists. Please choose a different SKU.";
            die;
        }

        $stmt = $pdo->prepare("INSERT INTO products (sku, product_name, product_price, furniture_height, furniture_width, furniture_length, productType) VALUES (:sku, :product_name, :product_price, :furniture_height, :furniture_width, :furniture_length, :productType)");
        $stmt->execute([
            ':sku' => $this->sku,
            ':product_name' => $this->productName,
            ':product_price' => $this->productPrice,
            ':furniture_height' => $this->height,
            ':furniture_width' => $this->width,
            ':furniture_length' => $this->length,
            ':productType' => $this->productType,
        ]);

        echo "Product saved successfully!";
    }
    

    public function displayDetails(PDO $pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE sku = :sku AND productType = 'Furniture'");
            $stmt->execute([':sku' => $this->sku]);
            $furnitureData = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "<h2>Furniture Product Details</h2>";
            echo "SKU: {$furnitureData['sku']}, Name: {$furnitureData['product_name']}, Price: {$furnitureData['product_price']}, 
                  Height: {$furnitureData['furniture_height']}, Width: {$furnitureData['furniture_width']}, Length: {$furnitureData['furniture_length']}";
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
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }
}

?>
