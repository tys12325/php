<!DOCTYPE html>
<!--//Name: FOONG SIANG HOONG ID:22WMR13703-->

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Starlight Glory</title>
        <style>
            body {
                margin: 0;
                font-family: 'Times New Roman', sans-serif;
                background-color: #121212; /* Dark background */
                color: #f0f0f0; /* Light text */
            }

            header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px;
                background-color: rgba(31, 31, 31, 0.8); /* Darker header with transparency */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
                font-size: 16pt;
                position: relative;
                z-index: 2;
            }

            .logo {
                display: flex;
                align-items: center;
            }

            .logo img {
                height: 60px;
                margin-right: 10px;
            }

            .logo h3 {
                font-size: 1.5rem;
                color: #f0f0f0;
            }

            .navigation ul {
                list-style: none;
                display: flex;
                gap: 20px;
                margin: 0;
                padding: 0;
            }

            .navigation a {
                text-decoration: none;
                color: #f0f0f0;
                font-weight: bold;
                transition: color 0.3s;
            }

            .navigation a:hover {
                color: #ffd700; /* Light Gold hover effect */
            }

            .search input {
                padding: 10px;
                border: none;
                border-radius: 5px;
                background-color: #2c2c2c; /* Dark input background */
                color: #f0f0f0;
                outline: none;
            }

            .cta-button button {
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                background-color: #ffd700; /* Light Gold button */
                color: #1f1f1f; /* Dark text on button */
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .cta-button button:hover {
                background-color: #e6c200; /* Slightly darker gold on hover */
            }

            .video-background {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 1;
            }

            .video-background video {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .login-section {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                position: relative;
                z-index: 2;
                padding: 20px;
            }

            .login-container {
                font-size: 14pt;
                height: 350px;
                width: 400px;
                background-color: rgba(31, 31, 31, 0.8); /* Semi-transparent background */
                padding: 40px;
                border-radius: 10px;
                text-align: center;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
                margin-top: -180px; /* Move container up */
            }

            .login-container h2 {
                margin-bottom: 20px;
                color: #ffd700; /* Light Gold */
            }

            .input-group {
                margin-bottom: 20px;
                text-align: left;
            }

            .input-group label {
                display: block;
                margin-bottom: 5px;
            }

            .input-group input {
                width: 100%;
                padding: 10px;
                border: none;
                border-radius: 5px;
                background-color: #2c2c2c; /* Dark input background */
                color: #f0f0f0;
            }


            button {
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                background-color: #ffd700; /* Light Gold button */
                color: #1f1f1f; /* Dark text on button */
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            button:hover {
                background-color: #e6c200; /* Slightly darker gold on hover */
            }

            footer {
                background-color: #1f1f1f; /* Deep Gold */
                color: #fff; /* White Text */
                padding: 2em 0;
                text-align: center;
                z-index: 2; /* Ensure it is above the video background */
                position: relative; /* Ensure it stays in place */
            }

            footer div {
                display: inline-block;
                width: 20%;
                text-align: left;
                padding: 0 1em;

            }

            footer h3 {
                font-size: 18px;
                margin-top: 0;
            }

            footer ul {
                list-style-type: none;
                padding: 0;
            }

            footer ul li {
                margin: 10px 0;
            }

            footer ul li a {
                text-decoration: none;
                color: #fff; /* White Text */
            }

            footer ul li a:hover {
                color: #ffd700; /* Light Gold hover effect */
            }




        </style>

    </head>
    <body>
        <header>
            <div class="logo">
                <img src="../Pictures/logo.png" alt="Starlight Glory">
                <h3>Starlight Glory</h3>
            </div>
            <nav class="navigation">
                <ul>
                    <li><a href="../Views/homePage.php">Home</a></li>
                    <li><a href="#collections">Collections</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="ourLocation.php">Contact</a></li>
                    <li><a href='../Public/index.php?url=pastOrder'>Past Order</a></li>
                    <li><a href='../Public/index.php?url=paymentHistory'">Payment History</a></li>
                </ul>
            </nav>
            <div class="search">
                <input type="text" placeholder="Search...">
            </div>
            <div class="cta-button">
                <button onclick="location.href = '#shop'">Shop Now</button>
            </div>
        </header>

        <div class="video-background">
            <video autoplay muted loop>
                <source src="../Pictures/hero.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <main class="login-section">
            <div class="login-container">
                <h2>Login</h2>
                <form action="../Controllers/loginController.php" method="post">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <p>
                    <a href="../Views/recoverPassword.php">Forgot Password?</a>
                </p>
                <p>Don't have an account? <a href="../Views/userRegister.php">Sign up</a></p>
            </div>
        </main>


        <footer class="footer">
            <div class="footer-section">
                <h3>About Us</h3>
                <ul>
                    <li>Our Story</li>
                    <li>Investor</li>
                    <li>Career</li>
                    <li>Our Services</li>
                    <li>Blog</li>
                    <li>Fraud Alert</li>
                    <li>Buy Online</li>
                    <li>Members</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Customer Service</h3>
                <ul>
                    <li>Contact Us</li>
                    <li>Terms & Conditions</li>
                    <li>Return & Refund Policy</li>
                    <li>Privacy Policy</li>
                    <li>Find Us</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Profile</h3>
                <ul>
                    <li>My Account</li>
                    <li>Order History</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Today Gold Price</h3>
                <ul>
                    <li>999 GOLD/gram - RM 425</li>
                    <li>916 GOLD/gram - RM 405</li>
                    <li>The gold prices displayed are indicated prices and for reference only. Please refer to your nearest Poh Kong outlet for the latest prices.</li>
                </ul>
            </div>
        </footer>
    </body>
</html>
