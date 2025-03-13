<!DOCTYPE html>
<!--//Name: FOONG SIANG HOONG ID:22WMR13703-->


<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            /* General Page Styles */
            body {
                font-family: Arial, sans-serif;
                background-color: #2c2c2c;
                color: #fff;
                margin: 0;
                padding: 0;
            }

            header {
                background-color: #333;
                color: white;
                padding: 10px 20px;
                text-align: center;
            }

            .container {
                display: inline-block;
                cursor: pointer;
                position: absolute;
                top: 20px;
                left: 20px;
            }

            .bar1, .bar2, .bar3 {
                width: 35px;
                height: 5px;
                background-color: white;
                margin: 6px 0;
                transition: 0.4s;
            }

            .change .bar1 {
                transform: translate(0, 11px) rotate(-45deg);
            }

            .change .bar2 {
                opacity: 0;
            }

            .change .bar3 {
                transform: translate(0, -11px) rotate(45deg);
            }

            .sidebar {
                height: 100%;
                width: 250px;
                position: fixed;
                top: 0;
                left: -250px;
                background-color: #333;
                overflow-x: hidden;
                transition: 0.5s;
                padding-top: 60px;
                z-index: 1;
            }

            .sidebar a {
                padding: 15px 25px;
                text-decoration: none;
                font-size: 18px;
                color: #818181;
                display: block;
                transition: 0.3s;
            }

            .sidebar a:hover {
                color: #f1f1f1;
            }

            .content {
                margin-left: 20px;
                padding: 20px;
                transition: margin-left 0.5s;
            }

            /* Sidebar toggle */
            .sidebar.open {
                left: 0;
            }

            .content.shifted {
                margin-left: 270px;
            }
        </style>
        <title>Admin Dashboard</title>
    </head>
    <body>

        <header>
            <h1>Admin Dashboard</h1>
            <div class="container" onclick="toggleMenu(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
        </header>

        <div class="sidebar" id="sidebar">
            <a href="adminPanel.php">Admin Panel</a>
            <a href="../transform.php">Total User</a>
            <a href="#reports">Reports</a>
            <a href="../Controllers/logOutController.php">Logout</a>
        </div>

        <div class="content" id="content">
            <h2>Welcome to the Admin Dashboard</h2>
            <p>Select an option from the menu to get started.</p>
        </div>

        <script>
            function toggleMenu(x) {
                x.classList.toggle("change");
                document.getElementById("sidebar").classList.toggle("open");
                document.getElementById("content").classList.toggle("shifted");
            }
        </script>

    </body>
</html>
