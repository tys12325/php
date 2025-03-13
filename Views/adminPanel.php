<!--//Name: FOONG SIANG HOONG ID:22WMR13703-->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel</title>
        <style>
            /* adminStyle.css */
            body {
                font-family: Arial, sans-serif;
                background-color: #2c2c2c;
                color: #fff;
                margin: 0;
                padding: 0;
            }

            header {
                background-color: #333;
                padding: 10px 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 3px solid #DAA520;
            }

            header .logo img {
                height: 50px;
            }

            header h3 {
                margin: 0;
                font-size: 1.5rem;
                color: #DAA520;
            }

            .navigation ul {
                list-style: none;
                margin: 0;
                padding: 0;
                display: flex;
            }

            .navigation ul li {
                margin: 0 15px;
            }

            .navigation ul li a {
                text-decoration: none;
                color: #fff;
                font-size: 1rem;
                transition: color 0.3s;
            }

            .navigation ul li a:hover {
                color: #DAA520;
            }

            .search input[type="text"] {
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 4px;
                background-color: #f4f4f4;
                color: #333;
            }

            .cta-button button {
                background-color: #DAA520;
                color: #333;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                border-radius: 5px;
                font-size: 1rem;
                transition: background-color 0.3s;
            }

            .cta-button button:hover {
                background-color: #c29716;
            }

            .main-content {
                padding: 20px;
                max-width: 1500px;
                margin: 20px auto;
                background-color: #444;
                border-radius: 8px;

            }

            h1 {
                font-size: 2rem;
                margin-bottom: 20px;
                color: #DAA520;
                text-align: center;
            }

            .profile-container {
                display: flex;
                justify-content: space-between;
                gap: 20px;
                flex-wrap: wrap;
                height: 450px;
                width: 1400px;
            }

            .admin-form {
                background-color: #333;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
                flex: 1;
                min-width: 280px;
                max-width: 500px;
            }

            .admin-form h2 {
                font-size: 1.5rem;
                margin-bottom: 10px;
                color: #DAA520;
            }

            .admin-form label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            .admin-form input[type="text"],
            .admin-form input[type="date"],
            .admin-form input[type="email"],
            .admin-form input[type="password"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border-radius: 4px;
                border: 1px solid #ccc;
                background-color: #f4f4f4;
                color: #333;
            }

            .admin-form button {
                background-color: #DAA520;
                color: #333;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                border-radius: 5px;
                font-size: 1rem;
                transition: background-color 0.3s;
            }

            .admin-form button:hover {
                background-color: #c29716;
            }

            footer {
                background-color: #333;
                padding: 20px;
                color: #fff;
                text-align: center;
                border-top: 3px solid #DAA520;
                margin-top: 40px;
            }

            .footer-section {
                margin-bottom: 20px;
            }

            .footer-section h3 {
                color: #DAA520;
                margin-bottom: 10px;
            }

            .footer-section ul {
                list-style: none;
                padding: 0;
            }

            .footer-section ul li {
                margin-bottom: 5px;
            }

            .footer-section ul li:last-child {
                margin-bottom: 0;
            }

        </style>

    </head>
    <body>
        <header>
            <h1>Admin Panel</h1>
            <div class="container" onclick="toggleMenu(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
        </header>

        <main class="main-content">
            <h1>Admin Panel</h1>
            <div class="profile-container">
                <!-- Create User Form -->
                <form method="POST" action="../Controllers/adminController.php">
                    <input type="hidden" name="action" value="create">
                    <h2>Create User</h2>
                    <label for="create-username">Username:</label>
                    <input type="text" id="create-username" name="username" required>
                    <label for="create-dob">Date of Birth:</label>
                    <input type="date" id="create-dob" name="dob">
                    <label for="create-email">Email:</label>
                    <input type="email" id="create-email" name="email" required>
                    <label for="create-password">Password:</label>
                    <input type="password" id="create-password" name="password" required>
                    <label for="create-confirmpassword">Confirm Password:</label>
                    <input type="password" id="create-confirmpassword" name="confirmpassword" required>
                    <button type="submit">Create User</button>
                </form>

                <!-- Update User Form -->
                <form method="POST" action="../Controllers/adminController.php">
                    <input type="hidden" name="action" value="update">
                    <h2>Update User</h2>
                    <label for="update-email">Email:</label>
                    <input type="email" id="update-email" name="email" required>
                    <label for="update-username">New Username:</label>
                    <input type="text" id="update-username" name="username">
                    <label for="update-dob">New Date of Birth:</label>
                    <input type="date" id="update-dob" name="dob">
                    <label for="update-password">New Password:</label>
                    <input type="password" id="update-password" name="password">
                    <label for="update-confirmpassword">Confirm Password:</label>
                    <input type="password" id="update-confirmpassword" name="confirmpassword">
                    <button type="submit">Update User</button>
                </form>

                <!-- Delete User Form -->
                <form method="POST" action="../Controllers/adminController.php">
                    <input type="hidden" name="action" value="delete">
                    <h2>Delete User</h2>
                    <label for="delete-email">Email:</label>
                    <input type="email" id="delete-email" name="email" required>
                    <button type="submit">Delete User</button>
                </form>
            </div>
        </main>
    </body>
</html>
