<?php
//Name: Tan Yen Shi 22WMR13751
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        .nav a:first-child { 
            margin-top: 20px; 
            display: block; 
            width: fit-content; 
            margin-left: auto; 
            margin-right: auto; 
            margin-bottom: 10px;
        }
    </style>
    <link href="../Public/css/pay.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <header style="text-align: center">
        <span class="highlighted">
            <span class="large-circled-number">1</span> <hr class="long-line"> <span class="large-circled-number">2</span><hr class="long-line">
            <span class="large-circled-number">3</span>
        </span>
        <hr class="long-line"><span class="large-circled-number">4</span><hr class="long-line">  <span class="large-circled-number">5</span>
        <div class="details">
            <ul>
                <li><div class="highlighted">INFORMATION</div></li>
                <li><div class="highlighted">SHIPPING</div></li>
                <li><div class="highlighted">INVOICE</div></li>
                <li>PAYMENT</li>  
                <li>COMPLETE</li>
            </ul>
        </div>
    </header>
    <table id="items-table">
        <tbody>
            <!-- Order items will be populated here via JavaScript -->
        </tbody>
    </table>

    <?php
    // Include the JavaScript here
    echo $this->getInvoiceJavaScript();
    ?>
</body>
</html>
