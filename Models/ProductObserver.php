<?php
//Name: SIA YAO QING ID:22WMR13745
class ProductObserver {
    private $productId;
    private $weight;  // Weight of the product (gold)
    private $pdo;     // Database connection

    public function __construct($pdo, $productId, $weight) {
        $this->pdo = $pdo;
        $this->productId = $productId;
        $this->weight = $weight;
    }

    // This method is called when the gold price changes
    public function update($newGoldPrice) {
        $newProductPrice = $this->weight * $newGoldPrice;
        $formattedPrice = number_format($newProductPrice, 2, '.', '');  // 2 decimal places, period as decimal separator, no commas

        // Update the product price in the database
        $sql = "UPDATE product SET price = :price WHERE ProductID = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':price', $formattedPrice, $this->pdo::PARAM_STR);
        $stmt->bindParam(':id', $this->productId);
        $stmt->execute();

        echo "Product {$this->productId} price updated to {$newProductPrice}\n";
    }
}
