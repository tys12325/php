<?php
//Name: FOONG SIANG HOONG ID:22WMR13703

session_start(); // Start the session to access session variables
// Database credentials
$host = 'localhost';
$dbName = 'starlightglory'; // Change this to your actual database name
$user = 'admin123';
$password = 'AdminUser@1234';
$dsn = "mysql:host=$host; dbname=$dbName";

try {
    // Create a PDO instance
    $pdoObj = new PDO($dsn, $user, $password);
    $pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: userLogin.php"); // Redirect to login page if not logged in
        exit();
    }

    // Retrieve user information from the database
    $email = $_SESSION['email']; // Get the email from the session

    $sql = "SELECT username, dob, email FROM registeredUsers WHERE email = :email";
    $stmt = $pdoObj->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<p>User not found.</p>";
        exit();
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newUsername = $_POST['username'];
        $newDob = $_POST['dob'];
        $newEmail = $_POST['email'];
        $newPassword = $_POST['new_password'];
        $confirmNewPassword = $_POST['confirm_new_password'];

        // Only update the password if the new password fields are not empty and match
        if (!empty($newPassword) && !empty($confirmNewPassword)) {
            if ($newPassword === $confirmNewPassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $updateSql = "UPDATE registeredUsers SET username = :username, dob = :dob, email = :newEmail, password = :password WHERE email = :email";
                $updateStmt = $pdoObj->prepare($updateSql);
                $updateStmt->bindParam(':username', $newUsername);
                $updateStmt->bindParam(':dob', $newDob);
                $updateStmt->bindParam(':newEmail', $newEmail);
                $updateStmt->bindParam(':password', $hashedPassword);
                $updateStmt->bindParam(':email', $email);
                $updateStmt->execute();

                // Update the session email
                $_SESSION['email'] = $newEmail;

                echo "<p>Profile and password updated successfully.</p>";
                header("Refresh:0");
                exit();
            } else {
                echo "<p>New passwords do not match.</p>";
            }
        } else {
            // Update profile details without password
            $updateSql = "UPDATE registeredUsers SET username = :username, dob = :dob, email = :newEmail WHERE email = :email";
            $updateStmt = $pdoObj->prepare($updateSql);
            $updateStmt->bindParam(':username', $newUsername);
            $updateStmt->bindParam(':dob', $newDob);
            $updateStmt->bindParam(':newEmail', $newEmail);
            $updateStmt->bindParam(':email', $email);
            $updateStmt->execute();

            // Update the session email
            $_SESSION['email'] = $newEmail;

            echo "<p>Profile updated successfully.</p>";
            header("Refresh:0");
            exit();
        }
    }
} catch (PDOException $ex) {
    echo "<p>ERROR: " . $ex->getMessage() . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile - Starlight Glory</title>
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

            .main-content {
                max-width: 1200px;
                margin: 2rem auto;
                padding: 0 2rem;
            }

            .profile-header {
                text-align: center;
                margin-bottom: 2rem;
            }

            .profile-header h1 {
                font-size: 2.5rem;
                color: #333;
                margin-bottom: 0.5rem;
            }

            .profile-header p {
                font-size: 1.2rem;
                color: #777;
            }

            .profile-container {
                background-color: #1f1f1f; /* Darker header */
                padding: 2rem;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .profile-container p {
                margin-bottom: 1.5rem;
            }

            .profile-container strong {
                display: inline-block;
                width: 150px;
                font-weight: bold;
            }

            .edit-profile {
                display: flex;
                justify-content: flex-end;
            }

            .edit-profile button {
                background-color: #1c1c1c;
                color: #fff;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .edit-profile button:hover {
                background-color: #333;
            }

            form input[type="text"],
            form input[type="email"],
            form input[type="date"] {
                width: 100%;
                padding: 0.5rem;
                border-radius: 4px;
                border: 1px solid #ccc;
                margin-bottom: 1rem;
                font-size: 1rem;
            }

            form button[type="submit"] {
                background-color: #ffd700; /* Light Gold button */
                color: black;
                font-weight: bold;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            form button[type="submit"]:hover {
                background-color: #b8902f;
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

        </style>
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="../Pictures/logo.png" alt="Starlight Glory">
                <h3>STARLIGHT GLORY</h3>
            </div>
            <nav class="navigation" >
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
                <button onclick="location.href = '../Controllers/logOutController.php'">Log Out</button>

            </div>
        </header>

        <main class="profile-section">
            <h1>Your Profile</h1>
            <div class="profile-container">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            </div>

            <!-- Form for updating profile details -->
            <form action="myProfile.php" method="POST" class="update-form">
                <h2>Update Profile</h2>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <button type="submit">Update</button>

                <h3>Change Password (optional)</h3>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password">

                <label for="confirm_new_password">Confirm New Password:</label>
                <input type="password" id="confirm_new_password" name="confirm_new_password">
                <button type="submit">Update</button>
                <br>
                <br>
            </form>
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