<?php
//Author: Tan Yen Shi 22WMR13751
class Database {
    private static $host = 'localhost';
    private static $dbName = 'starlightglory';
    private static $username = 'admin123';
    private static $password = 'AdminUser@1234';
    private static $connection;

    public static function getConnection() {
        if (!self::$connection) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbName, 
                    self::$username, 
                    self::$password
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                http_response_code(500);
                error_log("An internal server error occurred.");
                header('Location: ?url=error');
                exit();
                die("An error occurred. Please try again later.");  // Show a generic message to the user
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }

    public static function closeConnection() {
        self::$connection = null;
    }
}

?>
