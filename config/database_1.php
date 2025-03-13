<?php
class Database {

    private $pdo;

    public function getConnection() {
        try {
            // Assign the PDO instance to the class property $this->pdo
            $this->pdo = new PDO("mysql:host=localhost;dbname=starlightglory", "admin123", "AdminUser@1234");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Return a JSON encoded error message
            echo json_encode(['message' => 'Database connection error: ' . $e->getMessage()]);
            exit;
        }

        return $this->pdo; // Return the PDO connection
    }
}
