<?php
//Name: Tan Yen Shi 22WMR13751
?>
<html>
    <head>
        <title>Payment Successful</title>
        <link href="../Public/css/pay.css" rel="stylesheet" type="text/css"/>

        <style>
            h1 {
                text-align: center;
                color: #333;
                margin-top: 50px;
                font-size: 36px;
                font-weight: bold;
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
        </style>
    </head>

    <script type="text/javascript">
        window.onload = function() {
            // Automatically redirect to the download link for generating the invoice
            window.location.href = "?url=invoicePDF";
        };
    </script>

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
                    <li><div>COMPLETE</div></li>
                </ul>
            </div>
        </header>

        <h1>Payment Successful!</h1>

        <a href="?url=sendMail" class="button">Click Here To Complete Payment</a> 
    </body>
</html>
