<?php
//Author: Tan Yen Shi 22WMR13751
require_once '../config/Database.php'; // Adjust the path as necessary

// Start session to manage user sessions
session_start();

// Check if cartItemID is set in the URL
if (isset($_GET['cartItemID']) && !empty($_GET['cartItemID'])) {
    // Sanitize input
    $cartItemID = htmlspecialchars($_GET['cartItemID']);

    try {
        // Get database connection
        $conn = Database::getConnection();
        
        // Begin transaction
        $conn->beginTransaction();
        
        // Retrieve the CartID from the CartItem table
        $sql = "SELECT CartID FROM CartItem WHERE CartItemID = :cartItemID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cartItemID', $cartItemID, PDO::PARAM_STR);
        $stmt->execute();
        
        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cartItem) {
            $cartID = $cartItem['CartID'];
            
            // Remove the item from CartItem table
            $sql = "DELETE FROM CartItem WHERE CartItemID = :cartItemID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cartItemID', $cartItemID, PDO::PARAM_STR);
            $stmt->execute();
            
            // Recalculate NumberOfItems and TotalAmt for the Cart
            $sql = "SELECT COUNT(*) AS NumberOfItems, SUM(TotalAmt) AS TotalAmt FROM CartItem WHERE CartID = :cartID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cartID', $cartID, PDO::PARAM_STR);
            $stmt->execute();
            
            $cartTotals = $stmt->fetch(PDO::FETCH_ASSOC);
            $numberOfItems = $cartTotals['NumberOfItems'];
            $totalAmt = $cartTotals['TotalAmt'];
            
            // Update the Cart table
            $sql = "UPDATE Cart SET NumberOfItems = :numberOfItems, TotalAmt = :totalAmt WHERE CartID = :cartID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':numberOfItems', $numberOfItems, PDO::PARAM_INT);
            $stmt->bindParam(':totalAmt', $totalAmt, PDO::PARAM_STR);
            $stmt->bindParam(':cartID', $cartID, PDO::PARAM_STR);
            $stmt->execute();
            
            // Commit transaction
            $conn->commit();
            
            $_SESSION['message'] = "Item removed successfully!";
        } else {
            $_SESSION['message'] = "Item not found.";
        }

    } catch (PDOException $e) {
        // Rollback transaction if an error occurs
        $conn->rollBack();
        error_log("An internal server error occurred.");
        header('Location: ?url=error');
        exit();
        die("An error occurred. Please try again later.");  // Show a generic message to the user
        $_SESSION['message'] = "Database error: " . $e->getMessage();
    }

    // Close the connection
    Database::closeConnection();
} else {
    $_SESSION['message'] = "Invalid item ID.";
}

// Redirect back to the cart page or show a message
header('Location: ../Public/index.php?url=cart'); // Adjust the path as necessary
exit();
?>
