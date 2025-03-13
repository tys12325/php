<!--//Name: FOONG SIANG HOONG ID:22WMR13703-->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Our Location and Contact</title>
        <style>
            body {
                margin: 0;
                font-family: 'Times New Roman', serif;
                background-color: #121212; /* Dark background */
                color: #f0f0f0; /* Light text */
            }

            header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px;
                background-color: #1f1f1f; /* Darker header */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
                font-size: 16pt;
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

            main {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 20px;
            }

            .location-contact {
                text-align: center;
            }

            h1 {
                font-size: 3rem;
                color: #ffd700; /* Light Gold */
                margin-bottom: 20px;
            }

            p {
                font-size: 1.5rem;
                line-height: 1.5;
                margin-bottom: 20px;
                max-width: 600px;
            }

            strong {
                color: #ffd700; /* Light Gold */
            }

            iframe {
                border: 0;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            }

            .footer {
                background-color: #1f1f1f; /* Deep Gold */
                color: #fff; /* White Text */
                padding: 2em 0;
                text-align: center;
            }

            .footer div {
                display: inline-block;
                width: 20%;
                text-align: left;
                padding: 0 1em;
            }

            .footer h3 {
                font-size: 18px;
                margin-top: 0;
            }

            .footer ul {
                list-style-type: none;
                padding: 0;
            }

            .footer ul li {
                margin: 10px 0;
            }

            .footer a {
                text-decoration: none;
                color: #fff;
            }

            .footer a:hover {
                color: #121212;
            }

        </style>
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="../Pictures/logo.png" alt="Starlight Glory">
                <h3>STARLIGHT GLORY</h3>
            </div>
            <nav class="navigation">
                <ul>
                    <li><a href="../Views/homePage.php">Home</a></li>
                    <li><a href="../Views/homePage.php#collections">Collections</a></li>
                    <li><a href="../Views/homePage.php#about">About Us</a></li>
                    <li><a href="../Views/ourLocation.php">Contact</a></li>
                    <li><a href='../Public/index.php?url=pastOrder'>Past Order</a></li>
                    <li><a href='../Public/index.php?url=paymentHistory'">Payment History</a></li>
                </ul>
            </nav>
            <div class="search">
                <input type="text" placeholder="Search...">
            </div>
            <div class="cta-button">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <button onclick="location.href = '../Models/myProfile.php'">View My Profile</button>
                <?php else: ?>
                    <button onclick="location.href = 'userLogin.php'">Login</button>
                <?php endif; ?>

                <button onclick="location.href = '../Public/index.php?url=cart'">Cart</button>

            </div>
        </header>

        <main>
            <section class="location-contact">
                <h1>Our Location and Contact</h1>

                <p>
                    <strong>Location:</strong>
                    <br>Lot 2.02.00, Level 2 Pavilion, 168, Jln Bukit Bintang, Bukit Bintang, 55100 Kuala Lumpur, Wilayah Persekutuan
                </p>

                <p>
                    <strong>Phone:</strong> 
                    <br>012-3456789
                </p>

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d254983.46456103446!2d101.60978841861568!3d3.063475936160089!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc362c63402871%3A0x9852b66612a3d00d!2sPoh%20Kong%20Jewellers%20Sdn%20Bhd!5e0!3m2!1sen!2smy!4v1721664013346!5m2!1sen!2smy" width="600" height="450" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </section>
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
