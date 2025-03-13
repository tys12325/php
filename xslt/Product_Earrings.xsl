<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
        <html>
            <head>
                <title>Product List</title>
                <link rel="stylesheet" href="exports/homePageCss.css"></link>

            </head>
            <body>
                <header>
                    <div class="logo">
                        <img src="Public/Pictures/logo.png" alt="Starlight Glory"/>
                        <h3>STARLIGHT GLORY</h3>
                    </div>
                    <nav class="navigation">
                        <ul>
                            <li>
                                <a href="Views/homepage.php">Home</a>
                            </li>
                            <li>
                                <a href="#collections">Collections</a>
                            </li>
                            <li>
                                <a href="#about">About Us</a>
                            </li>
                            <li>
                                <a href="Views/ourLocation.php">Contact</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="search">
                        <input type="text" placeholder="Search..."/>
                    </div>
                    <div class="cta-button">
                        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                            <button onclick="location.href = 'Models/myProfile.php'">View My Profile</button>
                        <?php else: ?>
                            <button onclick="location.href = 'Views/userLogin.php'">Login</button>
                        <?php endif; ?>

                        <button onclick="location.href = 'Public/index.php?url=cart'">Cart</button>

                    </div>
                    <label for="currency-selector"></label>
                    <select id="currency-selector">
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                        <option value="MYR" selected="selected">MYR</option>
                    </select>
                </header>

                <h1>Necklace</h1>

                <!-- Product List -->
                <div id="product-list">
                    <xsl:apply-templates select="Products/Product"/>
                </div>

                <script>
                    <![CDATA[
                    // JavaScript function to change currency
                    function changeCurrency() {
    var selectedCurrency = document.getElementById("currency-selector").value;
    var prices = document.getElementsByClassName("price");

    // Loop through each product price
    for (var i = 0; i < prices.length; i++) {
        var priceElement = prices[i];

        // Get all prices stored in data-* attributes
        var priceUSD = priceElement.getAttribute("data-usd");
        var priceEUR = priceElement.getAttribute("data-eur");
        var priceGBP = priceElement.getAttribute("data-gbp");
        var priceMYR = priceElement.getAttribute("data-myr");

        // Set the price and hidden input based on the selected currency
        if (selectedCurrency === "USD") {
            priceElement.innerHTML = "$ " + priceUSD + " USD";
            priceElement.closest('.product').querySelector("input[name='price']").value = priceUSD;
        } else if (selectedCurrency === "EUR") {
            priceElement.innerHTML = "€ " + priceEUR + " EUR";
            priceElement.closest('.product').querySelector("input[name='price']").value = priceEUR;
        } else if (selectedCurrency === "GBP") {
            priceElement.innerHTML = "£ " + priceGBP + " GBP";
            priceElement.closest('.product').querySelector("input[name='price']").value = priceGBP;
        } else if (selectedCurrency === "MYR") {
            priceElement.innerHTML = "RM " + priceMYR + " MYR";
            priceElement.closest('.product').querySelector("input[name='price']").value = priceMYR;
        }
    }
}



// Ensure the function runs after the page has loaded
window.onload = function() {
    document.getElementById("currency-selector").onchange = changeCurrency;
};
                    ]]>
                </script>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="Product">
        <xsl:if test="CategoryID = '4'">
            <div class="product" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                <h2>
                    <xsl:value-of select="ProductName"/>
                </h2>
                <p>Product ID: <xsl:value-of select="ProductID"/></p>
                <p>Category ID: <xsl:value-of select="CategoryID"/></p>
                <p>Quantity: <xsl:value-of select="Quantity"/></p>
                <p>Weight: <xsl:value-of select="Weight"/>g</p>

                <!-- Export all currency prices as data attributes -->
                <p class="price"
                   data-usd="{Price/USD}"
                   data-eur="{Price/EUR}"
                   data-gbp="{Price/GBP}"
                   data-myr="{Price/MYR}">
                    <!-- Default Price: MYR -->
                    RM <xsl:value-of select="Price/MYR"/> MYR
                </p>

                <!-- Image with 50% width -->
                <img>
                    <xsl:attribute name="src">
                        <xsl:value-of select="concat('data:image/jpeg;base64,', Image)"/>
                    </xsl:attribute>
                    <xsl:attribute name="alt">
                        <xsl:value-of select="ProductName"/>
                    </xsl:attribute>
                    <xsl:attribute name="style">width: 10%;</xsl:attribute>
                </img>

                <!-- Add to Cart button -->
                <form action="Controllers/cart_handler.php" method="post">
                    <input type="hidden" name="product_id" value="{ProductID}"/>
                    <input type="hidden" name="product_name" value="{ProductName}"/>
                    <input type="hidden" name="price" value="{Price/MYR}"/>
                    <button type="submit" class="cart-button" style="background-color: green; color: white; padding: 5px 10px; border: none; cursor: pointer;">
                        Add to Cart
                    </button>
                </form>
            </div>
        </xsl:if>
    </xsl:template>

</xsl:stylesheet>
