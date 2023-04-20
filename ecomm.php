<?php

// Include the database configuration file
include 'config.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add the item to the user's cart
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $sql = "INSERT INTO cart_items (user_id, product_id, quantity)
            VALUES ({$_SESSION['user_id']}, $product_id, $quantity)
            ON DUPLICATE KEY UPDATE quantity = quantity + $quantity";
    mysqli_query($conn, $sql);
}

// Fetch the list of products
   $sql = "SELECT * FROM products";
   $result = mysqli_query($conn, $sql);
   
   ?>
   
   <html>
   <head>
       <title>My Store</title>
   </head>
   <body>
       <h1>Welcome to my store, <?php echo $_SESSION['username']; ?>!</h1>
   
       <h2>Products</h2>
       <?php while ($row = mysqli_fetch_assoc($result)): ?>
           <h3><?php echo $row['name']; ?></h3>
           <p><?php echo $row['description']; ?></p>
           <p>Price: $<?php echo $row['price']; ?></p>
           <form method="post">
               <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
               <label for="quantity">Quantity:</label>
               <input type="number" name="quantity" value="1" min="1"><br>
               <input type="submit" value="Add to Cart">
           </form>
           <hr>
       <?php endwhile; ?>
   </body>
   </html>

