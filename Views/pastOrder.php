<?php
//Name: Tan Yen Shi 22WMR13751
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(244, 244, 244);
            margin: 0;
            padding: 0;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgb(221, 221, 221);
        }
        th {
            background-color: rgb(200, 200, 200);
            font-weight: bold;
        }
        .status {
            font-weight: bold;
        }
        .status.pending {
            color: red;
        }
        a {
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .button, .button a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 15px;
            color: black;
            background-color: white;
            border: none;
            border-radius: 4px;
            box-shadow: 2px 2px grey;
            text-align: center;
            text-decoration: none;
        }
        .button.pending {
            background-color: red;
        }
        .button:hover {
            opacity: 0.65;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        .nav {
            margin-top: 30px;
            text-align: center;
        }
        .sort-icon {
            font-size: 12px;
            padding-left: 5px;
        }
        .message {
            text-align: center;
            padding: 50px;
            font-size: 18px;
            color: #555;
        }
        .message a {
            color: #337ab7;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Order History</h1>
        <?php if (isset($notLoggedIn)): ?>
            <div class="message">
                <p>You are not logged in. <a href="../Views/userLogin.php">Login</a> to view your order history.</p>
            </div>
        <?php else: ?>
            <?php if (!empty($orders)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>
                                Order Date
                                <!-- Sort icons and links for ascending and descending order -->
                                <a href="index.php?url=pastOrder&sort=asc">↑</a>
                                <a href="index.php?url=pastOrder&sort=desc">↓</a>
                            </th>
                            <th>Status</th>
                            <th>Total Amount</th>
                            <th>Invoice ID</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                            <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                            <td class="status <?php echo ($order['Status'] === 'Pending') ? 'pending' : ''; ?>">
                                <?php echo htmlspecialchars($order['Status']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($order['TotalAmt']); ?></td>
                            <td><?php echo htmlspecialchars($order['InvoiceID']); ?></td>
                            <td>
                                <?php if ($order['InvoiceID']): ?>
                                    <a href="index.php?url=setOrderID&orderID=<?php echo htmlspecialchars($order['OrderID']); ?>&invoiceID=<?php echo htmlspecialchars($order['InvoiceID']); ?>" class="button <?php echo ($order['Status'] === 'Pending') ? 'pending' : ''; ?>">View Invoice</a>
                                <?php else: ?>
                                    No Invoice
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No order history available.</p>
            <?php endif; ?>
        <?php endif; ?>
        <div class="nav">
            <a href="../Views/homePage.php" class="button" style="width: 250px;">Back To Home</a> 
        </div>
    </div>
</body>
</html>
