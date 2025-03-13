
<?php
//Name: SIA YAO QING ID:22WMR13745
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Product Management</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  

        <style>   :root{
                --main-color: #121212;
                --text-grey: #8390A2;
            }

            *{
                padding: 0;
                margin: 0;
                box-sizing: border-box;
                list-style: none;
                text-decoration: none;
                font-family: 'Poppins', sans-serif;
            }


            button {
                padding: 10px 20px;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
            }
            button:hover {
                background-color: #45a049;
            }
            .sidebar{
                width: 345px;
                position: fixed;
                left: 0;
                top: 0;
                height: 100%;
                background: var(--main-color);
                color: white;
                z-index: 100%;
            }
            .sidebar-brand{
                height: 90px;
                padding: 1rem 0rem 1rem 2rem;
                color: #fff;
            }
            .sidebar-brand span{
                display: inline-block;
                padding-right: 1rem;
            }
            .sidebar-menu li{
                width: 100%;
                margin-bottom: 1.3rem;
                margin-top: 10px;
                padding-left: 2rem;
            }
            .sidebar-menu a{
                padding-left: 1rem;
                display: block;
                color: #fff;
                font-size: 1.2rem;
            }
            .sidebar-menu{
                margin-top: 1rem;
            }

            .sidebar-menu a:hover{
                background: white;
                color: var(--main-color);
            }

            .sidebar-menu a:hover{
                background: #fff;
                padding-top: 1rem;
                padding-bottom:  1rem;
                color: var(--main-color);
                border-radius: 30px 0px 0px 30px;

            }



            .logo img,
            .sidebar-menu img{
                height: 50px; /* Adjust the height of the logo */
                margin-right: 10px; /* Space between logo and title */
                vertical-align: middle; /* Align image with text */

            }




            .main-content{
                margin-left: 345px;
                padding-top: 1rem;
                padding-left: 1rem;
                color: black;

            }




            table {
                width: 80%;
                margin: 20px auto;
                border-collapse: collapse;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            th, td {
                padding: 10px;
                border: 1px solid #ddd;
                text-align: left;
            }

            th {
                background-color: #f4f4f4;
            }

            td input[type="text"],
            td input[type="number"],
            td textarea,
            td select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            td input[type="checkbox"] {
                width: auto;
            }

            td button {
                background-color: #ff4b5c;
                color: white;
                border: none;
                padding: 8px 16px;
                cursor: pointer;
                border-radius: 4px;
                transition: background-color 0.3s;
            }

            .button-container {
                width: 80%;
                margin: 20px auto;
                display: flex;

            }

            button[type="button"] {
                background-color: #4CAF50;
                color: white;
                border: none;
                padding: 10px 20px;

                margin-right: 10px;
                cursor: pointer;
                border-radius: 4px;
                transition: background-color 0.3s;
            }

            button[type="button"]:hover {
                background-color: #45a049;
            }


            .products-container {
                padding-top: 20px;
                margin-top: 20px;
            }

            .product-item {
                border: 1px solid #ccc;
                padding: 10px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>


        <div class="sidebar">
            <div class="sidebar-brand">
                <a href="../homePage.php"><h1><span class="logo"><img src="Pictures/logo.png" alt="alt"/></span>Starlight Glory</h1></a>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="../Views/GoldPrice/goldpriceview.html" data-image-hover="Pictures/dashboard.png">
                            <span class="dashboard"><img src="Pictures/dashboard-white.png" alt="alt"/></span>
                            <span>Set Gold Price</span>
                        </a>
                    </li>

                    <li>
                        <a href="" data-image-hover="Pictures/user.png">
                            <span class=""><img src="Pictures/customer.png" alt="alt"/></span>
                            <span>Customers</span></a>
                    </li>
                    <li>
                        <a href="../Views/productAdminView.php" data-image-hover="Pictures/product-hover.png">
                            <span class=""><img src="Pictures/product.png" alt="alt"/></span>
                            <span>Load Products</span></a>
                    </li>
                    <li>
                        <a href="../transform.php" data-image-hover="Pictures/shopping-bag.png">
                            
                            <span class=""><img src="Pictures/order.png" alt="alt"/></span>
                            <span>Orders</span></a>
                    </li>
                    <li>
                        <a href="../Views/adminPanel.php" data-image-hover="Pictures/package-hover.png">
                            <span class=""><img src="Pictures/package white.png" alt="alt"/></span>
                            <span>Admin Panel</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <h2>Add New Product</h2>



            <form id="productForm" enctype="multipart/form-data">
                <table id="productTable">
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>New Category</th>
                        <th>Quantity</th>
                        <th>Weight</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </table>
                <div>
                    <button type="button" onclick="addRow()">Add Product</button>
                    <button type="button" onclick="submitProducts()">Submit Products</button>
                </div>
            </form>
            <br>




           <div id="productsContainer">
    <?php foreach ($products as $product): ?>
        <div class="product-item">
            <h3><?= htmlspecialchars($product['ProductName'], ENT_QUOTES, 'UTF-8') ?></h3>
            <p>Category: <?= htmlspecialchars($product['category_name'], ENT_QUOTES, 'UTF-8') ?></p>
            <p>Quantity: <?= htmlspecialchars($product['Quantity'], ENT_QUOTES, 'UTF-8') ?></p>
            <p>Weight: <?= htmlspecialchars($product['Weight'], ENT_QUOTES, 'UTF-8') ?>g</p>
            <p>Price: $<?= htmlspecialchars($product['Price'], ENT_QUOTES, 'UTF-8') ?></p>
            <p>Description: <?= htmlspecialchars($product['Description'], ENT_QUOTES, 'UTF-8') ?></p>
            
            <?php if (!empty($product['Image'])): ?>
                <img src="<?= htmlspecialchars($product['Image'], ENT_QUOTES, 'UTF-8') ?>" 
                     alt="<?= htmlspecialchars($product['ProductName'], ENT_QUOTES, 'UTF-8') ?>" 
                     style="max-width: 200px;">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

        </div>

        <script>
            document.querySelectorAll('.sidebar-menu a').forEach(function (menuItem) {
                var originalImgSrc = menuItem.querySelector('img').src;
                var newImage = menuItem.getAttribute('data-image-hover');

                menuItem.addEventListener('mouseover', function () {
                    menuItem.querySelector('img').src = newImage;
                });

                menuItem.addEventListener('mouseout', function () {
                    menuItem.querySelector('img').src = originalImgSrc;
                });
            });


            function addRow() {
                const table = document.getElementById('productTable');
                const rowCount = table.rows.length;
                const row = table.insertRow();
                const imagePreviewId = `imagePreview${rowCount}`;
                row.innerHTML = `
        <td><input type="text" name="product_id[]" placeholder="Product ID" required></td>
        <td><input type="text" name="name[]" placeholder="Product Name" required></td>
        <td>
            <select name="category_id[]" onchange="toggleNewCategoryInput(this)">
                <option value="">--Select Existing Category--</option>
<?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['CategoryID']) ?>"><?= htmlspecialchars($category['CategoryName']) ?></option>
<?php endforeach; ?>
            </select>
        </td>
        <td><input type="text" name="new_category[]" placeholder="New Category (leave empty if selecting existing) oninput="disableCategorySelect(this)"></td>
        <td><input type="number" name="quantity[]" placeholder="Quantity"></td>   
        <td><input type="number" name="weight[]" placeholder="Weight"></td>
        <td><input type="number" name="price[]" placeholder="Price" step="0.01" required></td>
        <td><textarea name="description[]" placeholder="Description" rows="4" cols="50"></textarea></td>
         <td> 
             <input type="file" name="image[]" accept="image/*" required onchange="previewImage(event, '${imagePreviewId}')">
             <img id="${imagePreviewId}" style="display: none; max-width: 300px; max-height: 300px;"/>
         </td>
        <td><button type="button" onclick="removeRow(this)">Remove</button></td>
            `;
            }

            function toggleNewCategoryInput(selectElement) {
                const newCategoryInput = selectElement.closest('tr').querySelector('input[name="new_category[]');
                if (selectElement.value) {
                    newCategoryInput.disabled = true;  // Disable new category input if an existing category is selected
                    newCategoryInput.value = "";  // Clear the new category input value
                } else {
                    newCategoryInput.disabled = false;  // Enable new category input if no existing category is selected
                }
            }

            function disableCategorySelect(inputElement) {
                const categorySelect = inputElement.closest('tr').querySelector('select[name="category_id[]"]');
                if (inputElement.value.trim() !== "") {
                    categorySelect.disabled = true;  // Disable category select if a new category is entered
                    categorySelect.value = "";  // Clear the category select value
                } else {
                    categorySelect.disabled = false;  // Enable category select if the new category input is empty
                }
            }

            function removeRow(button) {
                const row = button.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }


            function submitProducts() {
                const formData = new FormData(document.getElementById('productForm'));

                fetch('../Controllers/ProductController.php', {
                    method: 'POST',
                    body: formData
                })
                        .then(response => response.text())  // We first handle it as text to catch non-JSON responses
                        .then(text => {
                            console.log("Raw Response:", text);  // Log the raw response to debug

                            try {
                                const result = JSON.parse(text);  // Parse the JSON result
                                if (result.error) {
                                    alert('Error: ' + result.error);  // Show error alert if there's an error
                                } else if (result.message) {
                                    alert(result.message);  // Show success message
                                }
                            } catch (error) {
                                console.error('Failed to parse JSON:', error, text);
                                alert('Failed to parse JSON. Check console for details.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
            }





            function previewImage(event, previewId) {
                const reader = new FileReader();
                const preview = document.getElementById(previewId); // Get the unique preview element

                // Remove any existing image before adding the new one
                if (preview) {
                    preview.src = '';
                }

                reader.onload = function () {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(event.target.files[0]);
            }


        </script>
    </body>
