<?php
//Name: Tan Yen Shi 22WMR13751
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link href="../Public/css/pay.css" rel="stylesheet" type="text/css"/>
    <style>
        main {
            padding: 30px;
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Cart item styling */
        .cart-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: box-shadow 0.3s ease;
        }

        .cart-item:hover {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .item-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .product-name {
            font-size: 18px;
            font-weight: bold;
        }

        .quantity, .price, .total {
            font-size: 14px;
            color: #555;
        }

        .item-action {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center items horizontally */
        }

        .item-action .remove-link {
            color: #ff6f61;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border: 1px solid #ff6f61;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-top: 10px;
            text-align: center;
        }

        .item-action .remove-link:hover {
            opacity: 0.65;
        }

        /* Total amount */
        .cart-total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        /* Button styling */
        .button {
            display: inline-block;
            background-color: orange;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            max-width: 250px;
        }

        .button:hover {
            opacity: 0.65;
        }

        /* New class for button alignment */
        .button-container {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .button-container .button {
            max-width: none; /* Allow button to be full width if needed */
        }

        /* Responsive design */
        @media (max-width: 600px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .button-container {
                flex-direction: column;
                align-items: center;
            }

            .button-container .button {
                width: 100%;
                max-width: 250px;
                margin-bottom: 10px;
            }
        }

        .quantity-button {
            background-color: #ff6f61;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 16px;
            cursor: pointer;
            margin: 0 5px;
            transition: background-color 0.3s ease;
        }

        .quantity-button:hover {
            background-color: #e55c50;
        }
    </style>
</head>

<body>
    <header style="text-align: center">
        <span class="highlighted">
            <span class="large-circled-number">1</span> 
        </span>
        <hr class="long-line"> 
        <span class="large-circled-number">2</span>
        <hr class="long-line">
        <span class="large-circled-number">3</span>
        <hr class="long-line">
        <span class="large-circled-number">4</span>
        <hr class="long-line">
        <span class="large-circled-number">5</span>
        <div class="details">
            <ul>
                <li><div class="highlighted">INFORMATION</div></li>
                <li><div>SHIPPING</div></li>
                <li>INVOICE</li>
                <li>PAYMENT</li>    
                <li>COMPLETE</li>
            </ul>
        </div>
    </header>

    <main>
        <h2 style="text-align: center;">Your Cart</h2>
        <?php if (!empty($data['items'])): ?>
            <div class="cart-container">
                <?php
                $totalAmount = 0;
                foreach ($data['items'] as $item):
                    $productName = htmlspecialchars($item['ProductName']);
                    $weight = htmlspecialchars($item['Weight']);
                    $quantity = htmlspecialchars($item['Quantity']);
                    $price = htmlspecialchars($item['Price']);
                    $total = $quantity * $price; // Calculate total for each item
                    $totalAmount += $total;
                    $cartItemID = htmlspecialchars($item['CartItemID']); // Ensure this is properly escaped

                    // Handling image
                    $imageData = $item['Image']; // This should be base64-encoded already
                ?>
                    <div class="cart-item">
                        <img src="<?php echo $imageData; ?>" alt="<?php echo $productName; ?>" style="width: 100px; height: auto;">
                        <div class="item-info">
                            <p class="product-name"><?php echo $productName; ?></p>
                            <p class="weight">Weight: <?php echo number_format($weight, 2); ?> kg</p>
                            <p class="price">Price: $<?php echo number_format($price, 2); ?></p>
                            <p class="total">Total: $<?php echo number_format($total, 2); ?></p>
                        </div>
                        <div class="item-action">
                            <form action="../Controllers/updateQuantity.php" method="post" style="display: flex; align-items: center; flex-direction: column;">
                                <input type="hidden" name="cartItemID" value="<?php echo $cartItemID; ?>">
                                <div style="display: flex; align-items: center;">
                                    <button type="submit" name="action" value="decrement" class="quantity-button">-</button>
                                    <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" style="width: 55px; text-align: center; height: 22px;">
                                    <button type="submit" name="action" value="increment" class="quantity-button">+</button>
                                </div>
                                <a href="../Controllers/removeFromCart.php?cartItemID=<?php echo $cartItemID; ?>" class="remove-link">Remove</a>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="cart-total">
                    <p><strong>Total Amount: $<?php echo number_format($totalAmount, 2); ?></strong></p>
                </div>
            </div>
            <div class="button-container">
                <a href="../Views/homePage.php" class="button">Back To Home</a>
                <a href="?url=shipping" class="button">Proceed to Payment</a>
                
            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
            <a href="../Views/homePage.php" class="button">Back To Home</a>
        <?php endif; ?>
        
    </main>
</body>
</html>
