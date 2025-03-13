<?php
//Author: Tan Yen Shi 22WMR13751
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=localhost;dbname=starlightglory", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve POST data
        $productID = $_POST['product_id'];
        $productName = $_POST['product_name']; // Ensure this is used appropriately
        $price = $_POST['price'];
        $quantity = 1; // Assuming default quantity is 1. Modify as needed.

        // Check if user is logged in
        if (!isset($_SESSION['customerID'])) {
            echo json_encode(['error' => 'User not logged in.']);
            exit;
        }
        
        $userID = $_SESSION['customerID'];

        // Start a transaction
        $pdo->beginTransaction();

        // Check if the product exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Product WHERE ProductID = :productID");
        $stmt->execute(['productID' => $productID]);
        $productExists = $stmt->fetchColumn();

        if (!$productExists) {
            echo json_encode(['error' => 'Invalid ProductID.']);
            $pdo->rollBack();
            exit;
        }

        // Check if a cart exists for the user
        $stmt = $pdo->prepare("SELECT CartID FROM Cart WHERE userID = :userID");
        $stmt->execute(['userID' => $userID]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            // Cart exists, get the CartID
            $cartID = $cart['CartID'];
        } else {
            // No cart exists, create a new one
            $cartID = uniqid('cart_');
            $stmt = $pdo->prepare("INSERT INTO Cart (CartID, NumberOfItems, userID, TotalAmt) VALUES (:cartID, 0, :userID, 0)");
            $stmt->execute(['cartID' => $cartID, 'userID' => $userID]);
        }

        // Insert or update the item in the CartItem table
        $stmt = $pdo->prepare("INSERT INTO CartItem (CartItemID, CartID, ProductID, Quantity, Price, TotalAmt) 
                                VALUES (:cartItemID, :cartID, :productID, :quantity, :price, :totalAmt)
                                ON DUPLICATE KEY UPDATE Quantity = Quantity + VALUES(Quantity), TotalAmt = TotalAmt + VALUES(TotalAmt)");
        $stmt->execute([
            'cartItemID' => uniqid('item_'),
            'cartID' => $cartID,
            'productID' => $productID,
            'quantity' => $quantity,
            'price' => $price,
            'totalAmt' => $quantity * $price // Total amount for each CartItem is Quantity * Price
        ]);

        // Recalculate the total amount for the cart based on all items in CartItem table
        $stmt = $pdo->prepare("SELECT SUM(ci.Quantity * ci.Price) AS totalAmount
                               FROM CartItem ci
                               WHERE ci.CartID = :cartID");
        $stmt->execute(['cartID' => $cartID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get the calculated totalAmount
        $totalAmount = $result['totalAmount'];
        // Retrieve all cart items for view purposes (optional)
        $stmt = $pdo->prepare("SELECT ci.CartItemID, p.ProductID, p.ProductName, p.Price, p.Image, p.Weight, SUM(ci.Quantity) AS Quantity
                               FROM CartItem ci
                               JOIN Product p ON ci.ProductID = p.ProductID
                               WHERE ci.CartID = :cartID
                               GROUP BY p.ProductID, p.ProductName, p.Price, p.Image, p.Weight");
        $stmt->execute(['cartID' => $cartID]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Update the Cart table with the new total amount and number of items
        $stmt = $pdo->prepare("UPDATE Cart SET TotalAmt = :totalAmount, NumberOfItems = :numberOfItems WHERE CartID = :cartID");
        $stmt->execute([
            'totalAmount' => $totalAmount,  // Set the correct total amount
            'numberOfItems' => count($cartItems),  // Ensure you're counting the items correctly
            'cartID' => $cartID
        ]);

        // Commit the transaction
        $pdo->commit();

        echo json_encode(['success' => 'Item added to cart successfully.']);
        // Redirect to cart page
         header("Location: ../Public/index.php?url=cart");
        exit();
    } else {
        echo json_encode(['error' => 'Invalid request method.']);
    }
} catch (PDOException $e) {
    // Rollback in case of error
    $pdo->rollBack();
    error_log("An internal server error occurred: " . $e->getMessage());
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    header('Location: ?url=error');
    exit();
}
?>
