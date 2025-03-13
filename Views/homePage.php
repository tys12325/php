<!--//Name: FOONG SIANG HOONG ID:22WMR13703-->

<?php
session_start(); // Start the session to access session variables
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Starlight Glory</title>
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

            .hero {
                position: relative;
                width: 100%;
                height: 100vh;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .hero video {
                position: absolute;
                top: 50%;
                left: 50%;
                min-width: 100%;
                min-height: 100%;
                width: auto;
                height: auto;
                z-index: 1;
                transform: translate(-50%, -50%);
                background-size: cover;
                transition: 1s opacity;
            }

            .hero-content {
                position: relative;
                z-index: 2;
                color: #f0f0f0;
                text-align: center;
            }

            .hero h1 {
                font-size: 3rem;
                margin: 0 0 20px;
            }

            .hero p {
                font-size: 1.5rem;
                margin: 0 0 40px;
            }

            .hero button {
                padding: 15px 30px;
                border: none;
                border-radius: 5px;
                background-color: #ffd700; /* Light Gold button */
                color: #1f1f1f; /* Dark text on button */
                font-weight: bold;
                font-size: 1rem;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .hero button:hover {
                background-color: #e6c200; /* Slightly darker gold on hover */
            }

            /* General Section Styles */
            .shop-by-category,
            .gifts-for-loved-ones,
            .featured-collections,
            .about-us,
            .best-sellers,
            .testimonials,
            .collection-section {
                padding: 60px 20px;
                text-align: center;
            }

            h2 {
                font-size: 2.5rem;
                margin-bottom: 40px;
                color: #ffd700; /* Light Gold */
            }

            /* Collection and Product Grids */
            .gifts-grid,
            .collection-grid,
            .product-carousel,
            .testimonial-grid {
                display: flex;
                justify-content: center;
                gap: 20px;
                flex-wrap: wrap;
            }

            .category-grid {
                justify-content: center;
                gap: 20px;
                display: flex;
            }

            /* Individual Collection Items */
            .category-item,
            .collection-item,
            .product-item,
            .testimonial-item {
                background-color: #1f1f1f;
                padding: 20px;
                border-radius: 10px;
                text-align: center;
                transition: transform 0.3s, box-shadow 0.3s;
                width: 250px; /* Adjust as needed */
            }

            .category-item:hover,
            .collection-item:hover,
            .product-item:hover,
            .testimonial-item:hover {
                transform: translateY(-10px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            }

            .category-item img,
            .collection-item img,
            .product-item img,
            .about-content img {
                height: 200px;
                width: 200px;
                border-radius: 10px;
            }

            .collection-item img {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .collection-item h3 {
                margin: 15px 0 10px;
            }

            .collection-item p {
                font-size: 1rem;
            }

            /* Flip Effect for Gifts */
            .gift-item {
                perspective: 1000px;
                width: 250px;
                height: 400px;
                margin: 20px;
            }

            .gift-item-inner {
                position: relative;
                width: 100%;
                height: 100%;
                text-align: center;
                transition: transform 0.6s;
                transform-style: preserve-3d;
            }

            .gift-item:hover .gift-item-inner {
                transform: rotateY(180deg);
            }

            .gift-item-front,
            .gift-item-back {
                position: absolute;
                width: 100%;
                height: 100%;
                backface-visibility: hidden;
                border-radius: 8px;
            }

            .gift-item-front {
                background-color: #1f1f1f;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .gift-item-back {
                background-color: #1f1f1f; /* Darker header */
                color: #f0f0f0; /* Light text */
                transform: rotateY(180deg);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                font-size: 18pt;
                font-family: 'Times New Roman';
                text-align: left;
            }

            .gift-item img {
                height: 100%;
                width: 100%;
                border-radius: 8px;
            }

            /* Buttons in Collection and Product Items */
            .gift-item button,
            .product-item button {
                margin-top: 10px;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                background-color: #ffd700; /* Light Gold button */
                color: #1f1f1f; /* Dark text on button */
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .gift-item button:hover,
            .product-item button:hover {
                background-color: #e6c200; /* Slightly darker gold on hover */
            }

            /* About Section */
            .about-content {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }

            .about-content img {
                width: 100%;
                max-width: 600px;
                border-radius: 10px;
            }

            .about-content p {
                max-width: 800px;
                text-align: center;
                font-size: 1.2rem;
            }

            /* Testimonials */
            .testimonial-item {
                max-width: 300px;
                padding: 20px;
                background-color: #1f1f1f; /* Darker background for testimonials */
                border-radius: 10px;
            }

            .testimonial-item p {
                font-style: italic;
            }

            .testimonial-item h4 {
                margin-top: 10px;
                font-weight: bold;
                color: #ffd700; /* Light Gold */
            }

            /* Footer */
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

            .testimonial-item img {
                height: 250px;
                width: 250px;
            }

            .about-content img {
                height: 300px;
                width: 1000px;
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
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <button onclick="location.href = '../Models/myProfile.php'">View My Profile</button>
                <?php else: ?>
                    <button onclick="location.href = 'userLogin.php'">Login</button>
                <?php endif; ?>

                <button onclick="location.href = '../Public/index.php?url=cart'">Cart</button>

            </div>
        </header>

        <section class="hero">
            <video autoplay muted loop id="heroVideo">
                <source src="../Pictures/hero.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="hero-content">
                <h1>Discover the Timeless Elegance of Gold</h1>
                <p>Exquisite craftsmanship meets modern design</p>
                <button onclick="location.href = '#collections'">Explore Now</button>
            </div>
        </section>

        <section class="shop-by-category" id="shop-by-category">
            <h2>Shop by Category</h2>
            <div class="category-grid">
                <div class="category-item">
                    <a href="../Necklace.php">
                        <img src="../Pictures/necklace.png" alt="Necklaces">
                        <h3>Necklaces</h3></a>
                </div>
                <div class="category-item">
                    <a href="../Bracelet.php">
                        <img src="../Pictures/bracelet.webp" alt="Bracelets">
                        <h3>Bracelets</h3></a>
                </div>
               
                <div class="category-item">
                    <a href="../earring.php">
                        <img src="../Pictures/earring.png" alt="Earrings">
                        <h3>Earrings</h3></a>
                </div>
                <div class="category-item">
                    <a href="../ring.php">
                        <img src="../Pictures/ring.png" alt="Rings">
                        <h3>Rings</h3></a>
                </div>
            </div>
        </section>

        <section class="shop-by-category" id="shop-by-category">
            <h2>Gifts For Your Loved Ones</h2>
            <div class="gifts-grid">
                <div class="gift-item">
                    <div class="gift-item-inner">
                        <div class="gift-item-front">
                            <img src="../Pictures/forHim.jpg" alt="Gift for Him">
                        </div>
                        <div class="gift-item-back">
                            <p>Discover the perfect gift for the special man in your life. Our collection features timeless pieces that blend sophistication and style, ensuring he stands out with every wear. Show your appreciation with gifts that speak volumes about your affection.</p>
                        </div>
                    </div>
                </div>
                <div class="gift-item">
                    <div class="gift-item-inner">
                        <div class="gift-item-front">
                            <img src="../Pictures/forHer.png" alt="Gift for Her">
                        </div>
                        <div class="gift-item-back">
                            <p>Celebrate her unique beauty with our exclusive collection of gifts for her. From delicate necklaces to stunning earrings, each piece is crafted to perfection. Make her feel cherished and loved with jewellery that captures the essence of her elegance.</p>
                        </div>
                    </div>
                </div>
                <div class="gift-item">
                    <div class="gift-item-inner">
                        <div class="gift-item-front">
                            <img src="../Pictures/forKids.webp" alt="Gift for Kids">
                        </div>
                        <div class="gift-item-back">
                            <p>Bring joy and sparkle to the little ones with our delightful range of gifts for kids. Our fun and adorable pieces are designed to add a touch of magic to their everyday adventures. Perfect for birthdays, holidays, or just because.</p>
                        </div>
                    </div>
                </div>
                <div class="gift-item">
                    <div class="gift-item-inner">
                        <div class="gift-item-front">
                            <img src="../Pictures/forCouple.jpg" alt="Gift for Friends">
                        </div>
                        <div class="gift-item-back">
                            <p>Honor the bond you share with your significant other with our thoughtfully curated gifts for couples. Whether it's a matching set or complementary pieces, our collection is designed to symbolize your unique connection. Celebrate your love story with jewellery that tells your tale.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="collection-section" id="collections">
            <h2>Our Collections</h2>
            <div class="collection-grid">
                <div class="collection-item">
                    <img src="../Pictures/ring.png" alt="Ring">
                    <h3>Ring</h3>
                    <p>Our elegant gold ring is the epitome of sophistication, designed with intricate details and a timeless appeal that adds a touch of glamour to any outfit.</p>
                </div>
                <div class="collection-item">
                    <img src="../Pictures/bracelet.webp" alt="Bracelet">
                    <h3>Bracelet</h3>
                    <p>The charming gold bracelet blends delicate craftsmanship with modern style, making it a versatile accessory that can elevate any ensemble.</p>
                </div>
                <div class="collection-item">
                    <img src="../Pictures/necklace.png" alt="Necklace">
                    <h3>Necklace</h3>
                    <p>Adorn your neckline with our exquisite gold necklace, featuring a sophisticated design that captures the essence of timeless beauty, perfect for both everyday wear and special occasions.</p>
                </div>
                <div class="collection-item">
                    <img src="../Pictures/earring.png" alt="Earrings">
                    <h3>Earrings</h3>
                    <p>The stunning gold earrings are designed to make a statement with their exquisite detailing and impeccable finish, adding a touch of elegance to any look.</p>
                </div>
            </div>
        </section>

        <section class="best-sellers">
            <h2>Best Sellers</h2>
            <div class="product-carousel">
                <div class="product-item">
                    <img src="../Pictures/sample.png" alt="Product 1">
                    <h3>Product 1</h3>
                    <p>RM 1399</p>
                    <button>Add to Cart</button>
                </div>
                <div class="product-item">
                    <img src="../Pictures/sample.png" alt="Product 2">
                    <h3>Product 2</h3>
                    <p>RM 2299</p>
                    <button>Add to Cart</button>
                </div>
                <div class="product-item">
                    <img src="../Pictures/sample.png" alt="Product 3">
                    <h3>Product 3</h3>
                    <p>RM 2888</p>
                    <button>Add to Cart</button>
                </div>
            </div>
        </section>

        <section class="testimonials">
            <h2>What Our Customers Say</h2>
            <div class="testimonial-grid">
                <div class="testimonial-item">
                    <p>"Absolutely stunning pieces! I'm in love with my new necklace."</p>
                    <h4>- Foong Siang Hoong</h4>
                    <img src="../Pictures/foong.jpg" alt="Foong Siang Hoong">
                </div>
                <div class="testimonial-item">
                    <p>"Excellent craftsmanship and service. Highly recommend Starlight Glory."</p>
                    <h4>- Sia Yao Qing</h4>
                    <img src="../Pictures/sia.jpg" alt="Sia Yao Qing">
                </div>
                <div class="testimonial-item">
                    <p>"Beautiful jewellery that adds elegance to any outfit."</p>
                    <h4>- Tan Yen Shi</h4>
                    <img src="../Pictures/tan.png" alt="Tan Yen Shi">
                </div>
            </div>
        </section>

        <section class="about-us" id="about">
            <h2>About Starlight Glory</h2>
            <div class="about-content">
                <p>Starlight Glory has been creating timeless pieces of gold jewellery for over 50 years. Our dedication to exquisite craftsmanship and modern design ensures each piece is a work of art. Join us in celebrating the beauty and elegance of gold.</p>
                <img src="../Pictures/aboutUs.jpg" alt="About Us">
            </div>
        </section>

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

        <script src="script.js"></script>
    </body>
</html>
