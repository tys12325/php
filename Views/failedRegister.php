<!--//Name: FOONG SIANG HOONG ID:22WMR13703-->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Success - Starlight Glory</title>
        <style>
            /* successSignUp.css */

            /* General body styles */
            body {
                margin: 0;
                font-family: 'Times New Roman', sans-serif;
                background-color: #121212; /* Dark background */
                color: #f0f0f0; /* Light text */
            }

            /* Header styles */
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

            /* Video Background Styles */
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

            /* Success Page Styles */
            .success-section {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                position: relative;
                z-index: 2;
                padding: 20px;
            }

            .success-container {
                font-size: 18pt;
                background-color: rgba(31, 31, 31, 0.8); /* Semi-transparent background */
                padding: 40px;
                border-radius: 10px;
                text-align: center;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
                margin-top: -280px; /* Move container up */
            }

            .success-container h2 {
                margin-bottom: 20px;
                color: #ffd700; /* Light Gold */
            }

            .success-container p {
                margin: 10px 0;
                color: #f0f0f0;
            }

            .success-container a {
                color: #ffd700; /* Light Gold */
                text-decoration: none;
                font-weight: bold;
            }

            .success-container a:hover {
                color: #e6c200; /* Slightly darker gold on hover */
            }

            /* Footer Styles */
            footer {
                background-color: #d4af37; /* Deep Gold */
                color: #fff; /* White Text */
                padding: 2em 0;
                text-align: center;
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

            .loginbtn button {
                font-size: 15pt;
                height: 50px;
                width: 400px;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                background-color: #ffd700; /* Light Gold button */
                color: #1f1f1f; /* Dark text on button */
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .loginbtn button:hover {
                background-color: #e6c200; /* Slightly darker gold on hover */
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
                    <li><a href="homePage.php">Home</a></li>
                    <li><a href="#collections">Collections</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="ourLocation.php">Contact</a></li>
                </ul>
            </nav>
            <div class="search">
                <input type="text" placeholder="Search...">
            </div>
            <div class="cta-button">
                <button onclick="location.href = 'userLogin.php'">Login</button>
                <button onclick="location.href = '#shop'">Shop Now</button>
            </div>
        </header>

        <div class="video-background">
            <video autoplay muted loop>
                <source src="../Pictures/hero.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <main class="success-section">
            <div class="success-container">
                <h2>Please Try Again</h2>
                <p>Whoops! The Email or Password Had Been Used.</p><br> 
                <div class="loginbtn">
                    <button id="loginButton" onclick="location.href = 'userRegister.php'">Click Here To Try Again</button>
                </div>
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
