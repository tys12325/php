<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

class addAdminController {
    // Database credentials
    private $host = 'localhost';
    private $dbName = 'starlightglory'; // Change this to your actual database name
    private $user = 'admin123';
    private $password = 'AdminUser@1234';
    private $pdoObj;

    // Constructor to initialize PDO connection
    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbName}";
        try {
            $this->pdoObj = new PDO($dsn, $this->user, $this->password);
            $this->pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo "<p>ERROR: " . $ex->getMessage() . "</p>";
            exit();
        }
    }

    // Public function to add admin user
    public function addAdminUser($userID, $username, $dob, $email, $plainPassword) {
        try {
            // Hash the password
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

            // Prepare SQL query to insert admin user
            $sql = "INSERT INTO registeredUsers (userID, username, dob, email, password, isAdmin) 
                    VALUES (:userID, :username, :dob, :email, :password, :isAdmin)";
            $stmt = $this->pdoObj->prepare($sql);
            $stmt->bindParam(':userID', $userID);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindValue(':isAdmin', true, PDO::PARAM_BOOL); // Set isAdmin to TRUE

            // Execute the statement
            $stmt->execute();

            echo "Admin user added successfully!";
        } catch (PDOException $ex) {
            echo "<p>ERROR: " . $ex->getMessage() . "</p>";
        }
    }
}

// Usage example
$adminManager = new addAdminController();
$adminManager->addAdminUser('0000', 'adminUsername', '1980-01-01', 'admin@gmail.com', 'admin123');
?>
