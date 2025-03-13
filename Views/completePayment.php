<?php
//Name: Tan Yen Shi 22WMR13751
?>
<html>
    <head>
        <title>Order Confirmation</title>
        <link href="../Public/css/pay.css" rel="stylesheet" type="text/css"/>
        
        <style>
            h1 {
                text-align: center;
                color: #333;
                margin-top: 50px;
                font-size: 32px;
                font-weight: bold;
            }

            .message {
                text-align: center;
                color: #555;
                font-size: 18px;
                margin-top: 20px;
            }
            
            a.button {
                display: block;
                width: 250px;
                margin: 40px auto;
                padding: 15px 20px;
                background-color: orange;
                color: white;
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                border-radius: 5px;
                text-decoration: none;
            }
            
            a.button:hover {
                background-color: #ff9933;
            }

            a {
                display: block;
                text-align: center;
                margin-top: 20px;
                color: orange;
                text-decoration: none;
            }
            
            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>

    <body>
        <header style="text-align: center">
            <span class="highlighted">
                <span class="large-circled-number">1</span> 
                <hr class="long-line"> 
                <span class="large-circled-number">2</span>
                <hr class="long-line">
                <span class="large-circled-number">3</span>
                <hr class="long-line">
                <span class="large-circled-number">4</span>
                <hr class="long-line">
                <span class="large-circled-number">5</span>
            </span>

            <div class="details">
                <ul>
                    <li><div class="highlighted">INFORMATION</div></li>
                    <li><div class="highlighted">SHIPPING</div></li>
                    <li><div class="highlighted">INVOICE</div></li>
                    <li><div class="highlighted">PAYMENT</div></li>
                    <li><div class="highlighted">COMPLETE</div></li>
                </ul>
            </div>
        </header>

        <h1>Your order has been successfully placed!</h1>
        <div class="message">
            Thank you for your purchase. Your order is being processed, and we will notify you once it has been shipped.
        </div>

        <a href="../Views/homePage.php" class="button">Back To Home</a> 
        <a href="?url=invoicePDF">Generate Another Invoice</a>
    </body>
</html>
