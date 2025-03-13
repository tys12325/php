<html>
    <head>
        <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Product List</title>
        <link rel="stylesheet" href="../exports/homePageCss.css">
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="Public/Pictures/logo.png" alt="Starlight Glory">
                <h3>STARLIGHT GLORY</h3>
            </div>
            <nav class="navigation">
                <ul>
                    <li>
                        <a href="#home">Home</a>
                    </li>
                    <li>
                        <a href="#collections">Collections</a>
                    </li>
                    <li>
                        <a href="#about">About Us</a>
                    </li>
                    <li>
                        <a href="ourLocation.php">Contact</a>
                    </li>
                </ul>
            </nav>
            <div class="search">
                <input type="text" placeholder="Search...">
            </div>
            <div class="cta-button">
                <button onclick="location.href = '../Models/myProfile.php'">View My Profile</button><button onclick="location.href = '../Views/userLogin.php'">Login</button><button onclick="location.href = '../Public/index.php?url=cart'">Cart</button>
            </div>
            <label for="currency-selector"></label><select id="currency-selector"><option value="USD">USD</option><option value="EUR">EUR</option><option value="GBP">GBP</option><option value="MYR" selected="selected">MYR</option></select>
        </header>
      
        <script>
                    
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
                    
                </script>
    </body>
</html>
