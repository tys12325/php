<!DOCTYPE html>
<!--Name: SIA YAO QING ID:22WMR13745-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Admin Panel</title>
</head>
<body>

    <h1>Product Admin Panel</h1>

    <!-- Button to Export Products to XML -->
    <form action="../Controllers/ProductController.php" method="GET">
        <input type="hidden" name="action" value="exportToXML"> <!-- Hidden field for action -->
        <button type="submit">Export Products to XML</button>
    </form>

    <!-- Other content of your admin panel -->

</body>
</html>
