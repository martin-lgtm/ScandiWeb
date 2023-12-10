<?php

include('./config/Database.php');


abstract class Product {
    protected $id;
    protected $sku;
    protected $productName;
    protected $productPrice;

    protected $productType;


    public function __construct($sku, $productName, $productPrice) {
        $this->sku = $sku;
        $this->productName = $productName;
        $this->productPrice = $productPrice;
    }

    public function getId() {
        return $this->id;
    }

    public function getSku() {
        return (string) $this->sku;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
    }

    public function getProductPrice() {
        return $this->productPrice;
    }

    public function setProductPrice($productPrice) {
        $this->productPrice = $productPrice;
    }

    abstract public function displayDetails(PDO $pdo);
    
    
    public function delete(PDO $pdo) {
        try {
            $stmt = $pdo->prepare("DELETE FROM products WHERE sku = :sku");
            $stmt->execute([':sku' => $this->sku]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    public function save(PDO $pdo) {
        if (!$this->isSkuUnique($pdo)) {
            echo "SKU already exists. Please choose a different SKU.";
            return;
        }

        $stmt = $pdo->prepare("INSERT INTO products (sku, product_name, product_price, productType) VALUES (:sku, :product_name, :product_price, :productType)");
        $stmt->execute([
            ':sku' => $this->sku,
            ':product_name' => $this->productName,
            ':product_price' => $this->productPrice,
            ':productType' => $this->productType,
        ]);

        echo "Product saved successfully!";
    }

    protected function isSkuUnique(PDO $pdo) {
        $condition = ($this->id) ? "AND id != :id" : "";
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE sku = :sku $condition");
        
        if ($this->id) {
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        }
        
        $stmt->execute([':sku' => $this->sku]);
        $count = $stmt->fetchColumn();

        return $count === 0;
    }

}
