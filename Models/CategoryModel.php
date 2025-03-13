<?php
//Name: SIA YAO QING ID:22WMR13745
class CategoryModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }




    // Method to get all categories
    public function getAllCategories() {
        $sql = "SELECT * FROM category";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insertCategoryWithID($categoryId, $categoryName) {
    $sql = "INSERT INTO category (CategoryID, CategoryName) VALUES (:id, :name)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
    $stmt->bindParam(':name', $categoryName, PDO::PARAM_STR);
    
    return $stmt->execute();
}

    
     // Method to get the next category ID (latest ID + 1)
   public function getNextCategoryId() {
    try {
        $sql = "SELECT MAX(CategoryID) AS max_id FROM category";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if result is valid and max_id is not null
        if ($result && isset($result['max_id']) && $result['max_id'] !== null) {
            return (int) $result['max_id'] + 1;
        } else {
            return 1; // If there are no categories, start with ID 1
        }
    } catch (PDOException $e) {
        // Handle any potential database errors
        throw new Exception("Error retrieving next CategoryID: " . $e->getMessage());
    }
}

}
