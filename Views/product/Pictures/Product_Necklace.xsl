<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:template match="/">
    <html>
      <head>
        <title>Product List - Rings</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            margin: 20px;
          }
          .product {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            width: 250px;
            float: left;
            margin-right: 20px;
          }
          .product h2 {
            font-size: 20px;
            color: #333;
          }
          .product p {
            margin: 5px 0;
          }
          .product img {
            width: 100px;
            height: 100px;
            object-fit: cover;
          }
          .clear {
            clear: both;
          }
          .cart-button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            text-align: center;
          }
          .cart-button:hover {
            background-color: #218838;
          }
        </style>
      </head>
      <body>
        <h1>Product List - Rings</h1>
        <xsl:for-each select="Products/Product">
          <!-- Use '=' for comparison in XSLT -->
          <xsl:if test="CategoryID = '2'">
            <div class="product">
              <h2><xsl:value-of select="ProductName" /></h2>
              <p>Product ID: <xsl:value-of select="ProductID" /></p>
              <p>Category ID: <xsl:value-of select="CategoryID" /></p>
              <p>Quantity: <xsl:value-of select="Quantity" /></p>
              <p>Weight: <xsl:value-of select="Weight" />g</p>
              <p>Price: $<xsl:value-of select="Price" /></p>
              <p>
                <!-- XSLT for images, processing as base64 -->
                <xsl:variable name="imageData" select="Image"/>
                <img>
                  <xsl:attribute name="src">data:image/jpeg;base64,<xsl:value-of select="$imageData" /></xsl:attribute>
                  <xsl:attribute name="alt">
                    <xsl:value-of select="ProductName"/>
                  </xsl:attribute>
                </img>
              </p>
              <!-- Add to Cart form -->
              <form action="cart_handler.php" method="post">
                <input type="hidden" name="product_id" value="{ProductID}" />
                <input type="hidden" name="product_name" value="{ProductName}" />
                <input type="hidden" name="price" value="{Price}" />
                <button type="submit" class="cart-button">Add to Cart</button>
              </form>
            </div>
          </xsl:if>
        </xsl:for-each>
        <div class="clear"></div> <!-- Ensures float clear -->
      </body>
    </html>
  </xsl:template>

</xsl:stylesheet>
