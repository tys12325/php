<?php
//Name: Tan Yen Shi 22WMR13751
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment History</title>
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
            cursor: pointer;
        }

        a {
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        .nav {
            text-align: center;
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
        .button:hover {
            opacity: 0.65;
        }
        .sort-icon {
            margin-left: 5px;
            width: 12px;
            height: 12px;
        }
        .bold-column {
            font-weight: bold;
        }
        th a:hover {
            color: blue;
            text-decoration: none;
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
        <h1>Your Payment History</h1>
        <?php if (isset($notLoggedIn)): ?>
            <div class="message">
                <p>You are not logged in. <a href="../Views/userLogin.php">Login</a> to view your payment history.</p>
            </div>
        <?php elseif (isset($noPayments)): ?>
            <div class="message">
                <p>No payment history available at the moment.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>
                            Payment Date
                            <a href="index.php?url=paymentHistory&sort=asc">↑</a>
                            <a href="index.php?url=paymentHistory&sort=desc">↓</a>
                        </th>
                        <th>Payment Time</th>
                        <th>Amount</th>
                        <th>Invoice ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td class="bold-column"><?php echo htmlspecialchars($payment['PaymentID']); ?></td>
                            <td><?php echo htmlspecialchars($payment['PaymentDate']); ?></td>
                            <td><?php echo htmlspecialchars($payment['PaymentTime']); ?></td>
                            <td><?php echo htmlspecialchars($payment['Amount']); ?></td>
                            <td class="bold-column"><?php echo htmlspecialchars($payment['InvoiceID']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <div class="nav">
            <a href="../Views/homePage.php" class="button" style="width: 250px;">Back To Home</a> 
        </div>
    </div>
</body>
</html>
