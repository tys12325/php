<?php
//Name: SIA YAO QING ID:22WMR13745
class GoldPriceModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Set a new gold price and update the timestamp
    public function setGoldPrice($newPrice) {
        // Update the gold price in the table
        $sql = "INSERT INTO goldprice (GoldPrice) VALUES (:price)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':price', $newPrice);
        return $stmt->execute();
    }

    // Get the latest gold price from the table
    public function getGoldPrice() {
        $sql = "SELECT GoldPrice FROM goldprice ORDER BY LastUpdated DESC LIMIT 1";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result['GoldPrice'];
        }

        return null;  // Return null if no gold price is found
    }
}
