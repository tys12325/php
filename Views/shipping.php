<?php
//Name: Tan Yen Shi 22WMR13751
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shipping</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            
            header {
                text-align: center;
                background-color: #333;
                color: white;
                padding: 10px 0;
            }
            
            .highlighted {
                font-size: 20px;
                color: orange;
            }
            
            .large-circled-number {
                background-color: orange;
                border-radius: 50%;
                padding: 10px 15px;
                color: white;
                font-weight: bold;
            }
            
            .long-line {
                display: inline-block;
                width: 50px;
                border-top: 2px solid white;
                margin: 0 10px;
            }
            
            .details ul {
                list-style: none;
                padding: 0;
            }
            
            .details ul li {
                display: inline-block;
                padding: 10px;
                font-size: 18px;
                color: white;
            }
            
            form {
                width: 50%;
                margin: 20px auto;
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            }
            
            input[type="text"], textarea {
                width: 100%;
                padding: 10px;
                margin: 5px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            
            input[type="submit"] {
                background-color: orange;
                color: white;
                border: none;
                padding: 15px;
                width: 100%;
                font-size: 16px;
                cursor: pointer;
                border-radius: 5px;
            }
            
            input[type="submit"]:hover {
                background-color: darkorange;
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
        <link href="../Public/css/pay.css" rel="stylesheet" type="text/css"/>
        <script>
            function validateForm() {
                let isValid = true;
                const zipCode = document.getElementById('zip');
                const phoneNumber = document.getElementById('phone');
                const zipCodeRegex = /^\d{5}$/;
                const phoneRegex = /^01[0-46-9]-\d{7,8}$/;

                // Clear previous error messages and reset input styles
                document.getElementById('zipError').textContent = '';
                document.getElementById('phoneError').textContent = '';
                zipCode.style.borderColor = '';
                phoneNumber.style.borderColor = '';

                // Validate ZIP code (exactly 5 digits)
                if (!zipCodeRegex.test(zipCode.value)) {
                    document.getElementById('zipError').textContent = "Wrong ZIP code format! ZIP code must be exactly 5 digits.";
                    document.getElementById('zipError').style.color = "red";
                    zipCode.style.borderColor = 'red';
                    isValid = false;
                }

                // Validate phone number (Malaysia format)
                if (!phoneRegex.test(phoneNumber.value)) {
                    document.getElementById('phoneError').textContent = "Phone number must be in the format 01X-XXXXXXX (Malaysian format).";
                    document.getElementById('phoneError').style.color = "red";
                    phoneNumber.style.borderColor = 'red';
                    isValid = false;
                }

                if (!isValid) {
                    return false;  // If there are validation errors, prevent form submission
                }

                // Confirmation message
                return confirm("Important! The action cannot be undone once you have submitted your address. Do you want to proceed?");
            }
        </script>

</head>
<body>
        <header style="text-align: center">
            <span class="highlighted">
                <span class="large-circled-number">1</span> 
                <hr class="long-line"> 
                <span class="large-circled-number">2</span>
            </span>
            <hr class="long-line">
            <span class="large-circled-number">3</span>
            <hr class="long-line">
            <span class="large-circled-number">4</span>
            <hr class="long-line">
            <span class="large-circled-number">5</span>
            <div class="details">
                <ul>
                    <li><div class="highlighted">INFORMATION</div></li>
                    <li><div class="highlighted">SHIPPING</div></li>
                    <li>INVOICE</li>
                    <li>PAYMENT</li>    
                    <li>COMPLETE</li>
                </ul>
            </div>
        </header>
    
        <main>
            <h2 style="text-align: center;">Shipping Information</h2>

            <form action="?url=handleShippingSubmission" method="POST" onsubmit="return validateForm();">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="full_name" value="<?php echo htmlspecialchars($_SESSION['fullName']); ?>" required><br><br>

                <label for="address">Shipping Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($_SESSION['Address']); ?>" required><br><br>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($_SESSION['city']); ?>" required><br><br>

                <label for="state">State:</label>
                <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($_SESSION['state']); ?>" required><br><br>

                <label for="zip">ZIP Code:</label>
                <input type="text" id="zip" name="zip_code" value="<?php echo htmlspecialchars($_SESSION['zipCode']); ?>" required>
                <span id="zipError"></span><br><br> <!-- Error message for ZIP code -->

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone_number" value="<?php echo htmlspecialchars($_SESSION['phoneNumber']); ?>" required>
                <span id="phoneError"></span><br><br> <!-- Error message for phone number -->

                <label for="instructions">Special Instructions (Optional):</label>
                <textarea id="instructions" name="instructions"><?php echo htmlspecialchars($_SESSION['instructions'] ?? ''); ?></textarea><br><br>

                <input type="submit" value="Proceed to Invoice">
            </form>


            <a href="?url=cart">Go Back</a>
        </main>

</body>
</html>
