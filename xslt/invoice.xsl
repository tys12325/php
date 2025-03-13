<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>
    
    <xsl:template match="/">
        <html>
            <head>
                <meta charset="UTF-8"/>
                <title>Invoice #<xsl:value-of select="Invoice/InvoiceID"/></title>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        background-color: #f9f9f9; 
                    }
                    .container { 
                        width: 80%; 
                        margin: auto; 
                        background-color: #fff; 
                        padding: 20px; 
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
                    }
                    .header { 
                        text-align: center; 
                        margin-bottom: 20px; 
                    }
                    .info { 
                        margin-bottom: 20px; 
                    }
                    .info-row { 
                        display: flex; 
                        justify-content: space-between; 
                        margin-bottom: 10px; 
                    }
                    .info-item { 
                        flex: 1; 
                    }
                    .info-item-right { 
                        text-align: right; 
                    }
                    table { 
                        width: 100%; 
                        border-collapse: collapse; 
                        margin-bottom: 20px; 
                    }
                    table, th, td { 
                        border: 1px solid black; 
                    }
                    th, td { 
                        padding: 10px; 
                        text-align: left; 
                    }
                    th { 
                        background-color: #333;
                        color: white;
                    }
                    .total { 
                        text-align: right; 
                        font-weight: bold; 
                        margin-bottom: 20px; 
                    }
                    .nav { 
                        text-align: center; 
                        margin-top: 40px; 
                    }
                    .nav a { 
                        display: inline-block; 
                        padding: 10px 20px; 
                        margin: 5px; 
                        font-size: 15px;
                        background-color: black;
                        color: white; 
                        text-decoration: none; 
                        border-radius: 4px;
                        box-shadow: 2px 2px grey;
                        transition: background-color 0.3s ease; 
                        text-align: center;
                    }
                    .nav a:hover { 
                        opacity: 0.65; 
                    }
                </style>
            </head>
            <body>
                 <div class="container">
                     <div class="header">
                         <h1>Invoice #<xsl:value-of select="Invoice/InvoiceID"/></h1> <!-- Update here -->
                     </div>

                     <div class="info">
                         <div class="info-row">
                             <div class="info-item">
                                 <p><strong>Invoice To:</strong> <xsl:value-of select="Invoice/Customer/CustomerName"/></p>
                                 <p><strong>Address:</strong> <xsl:value-of select="Invoice/Customer/Address"/></p>
                             </div>
                             <div class="info-item info-item-right">
                                 <p><strong>Order ID:</strong> <xsl:value-of select="Invoice/Order/OrderID"/></p>
                                 <p><strong>Generated Date:</strong> <xsl:value-of select="Invoice/Order/OrderDate"/></p>
                                 <p><strong>Status:</strong> <xsl:value-of select="Invoice/Order/Status"/></p>
                                 <p><strong>Invoice ID:</strong> <xsl:value-of select="Invoice/InvoiceID"/></p> <!-- Update here -->
                             </div>
                         </div>
                     </div>

                     <table>
                         <thead>
                             <tr>
                                 <th>Product Name</th>
                                 <th>Weight</th>
                                 <th>Quantity</th>
                                 <th>Price</th>
                                 <th>Total</th>
                             </tr>
                         </thead>
                         <tbody>
                             <xsl:for-each select="Invoice/OrderItems/Item">
                                 <tr>
                                     <td><xsl:value-of select="ProductName"/></td>
                                     <td><xsl:value-of select="Weight"/> kg</td>
                                     <td><xsl:value-of select="Quantity"/></td>
                                     <td>$<xsl:value-of select="Price"/></td>
                                     <td>$<xsl:value-of select="Total"/></td>
                                 </tr>
                             </xsl:for-each>
                         </tbody>
                     </table>

                     <div class="total">
                         <p>Total Amount: $<xsl:value-of select="Invoice/Order/TotalAmt"/></p>
                     </div>

                     <div class="nav">
                         <a style="background-color:red" href="?url=invoicePDF">Download as PDF?</a>  
                         <a href="../Views/homePage.php">Back To Home</a>
                         <xsl:if test="Invoice/Order/Status = 'Pending'">
                             <a href="?url=checkout">Proceed to Payment</a>
                         </xsl:if>
                     </div>
                 </div>
             </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
