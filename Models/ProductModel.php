<?php
//Name: SIA YAO QING ID:22WMR13745
class ProductModel {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllProducts() {
        try {
            $stmt = $this->pdo->query('
                SELECT 
                    p.ProductID, 
                    p.ProductName, 
                    c.CategoryName AS category_name, 
                    p.CategoryID,
                    p.Quantity, 
                    p.Weight, 
                    p.Price, 
                    p.Description, 
                    p.Image
                FROM 
                    Product p
                JOIN 
                    Category c ON p.CategoryID = c.CategoryID
                ORDER BY 
                    p.ProductID ASC
            ');
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Process images for display
            foreach ($products as &$product) {
                if (!empty($product['Image'])) {
                    $product['Image'] = 'data:image/jpeg;base64,' . base64_encode($product['Image']);
                }
            }
            return $products;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }

    // Insert product into the database
    // Insert product data into the database
   public function insertProduct($product_id, $name, $category_id, $quantity, $weight, $price, $description, $image) {
        $stmt = $this->pdo->prepare('INSERT INTO Product (ProductID, ProductName, CategoryID, Quantity, Weight, Price, Description, Image) 
                                     VALUES (:ProductID, :ProductName, :CategoryID, :Quantity, :Weight, :Price, :Description, :Image)');
        return $stmt->execute([
            'ProductID' => $product_id,
            'ProductName' => $name,
            'CategoryID' => $category_id,
            'Quantity' => $quantity,
            'Weight' => $weight,
            'Price' => $price,
            'Description' => $description,
            'Image' => $image
        ]);
    }
    
   
}
?>
